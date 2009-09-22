<?php
define("ROOT", dirname(__FILE__));
require_once ROOT . "/library/helper/constants.php";
require_once ROOT . "/library/helper/functions.php";

define("WORKING_IN_BROWSER", !empty($_SERVER["HTTP_HOST"]));

// @TODO configurable: 1) default 2) user setting
setlocale(LC_ALL, "en_US");
bindtextdomain( "*", ROOT . "/languages/gettext" );
bind_textdomain_codeset("novaesx", "UTF-8");
textdomain("novaesx");


// Инклуды
set_include_path(
	ROOT . "/models/Base"
    . PATH_SEPARATOR . ROOT . "/models"
    . PATH_SEPARATOR . ROOT . "/application/controllers"
    . PATH_SEPARATOR . ROOT . "/library/helper"
    . PATH_SEPARATOR . ROOT . "/library/Doctrine"
    . PATH_SEPARATOR . ROOT . "/library"
    . PATH_SEPARATOR . get_include_path()
);


require_once "Zend/Loader/Autoloader.php";
Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(TRUE);
Zend_Loader_Autoloader::getInstance()->pushAutoloader(new Zend_Loader_Autoloader_RecordTable());
$loader = new Zend_Loader_Autoloader_PluginLoader();
$loader->addPrefixPath("Zend_View_Helper_", ROOT . "/application/views/helpers");
Zend_Loader_Autoloader::getInstance()->pushAutoloader($loader, "Zend_View_Helper_");
unset($loader);

// Загрузка настроек
$config = new Zend_Config_Ini(ROOT . "/config/common.ini", NULL, TRUE);
Zend_Registry::set("config", $config->merge(new Zend_Config_Ini(ROOT . "/config/local.ini")));

Zend_Registry::set("site_url", "http://{$config->web->hostname}/");
Zend_Registry::set("posters_url", "{$config->web->hostname}/img/posters");

// Журнал
Zend_Registry::set("log", new Zend_Log(new Zend_Log_Writer_Stream(LOGS_PATH . "/main.log")));

// Обработчики ошибок
set_error_handler("ErrorsController::handleError");
set_exception_handler("ErrorsController::handleException");
ini_set("display_errors", $config->server->development);
ini_set("display_startup_errors", $config->server->development);
Zend_Controller_Front::getInstance()->throwExceptions($config->server->development);

// Подключение к БД
$conn = Doctrine_Manager::connection(
    sprintf(
        "%s://%s:%s@%s/%s",
        $config->database->adapter,
        $config->database->username,
        $config->database->password,
        $config->database->hostname,
        $config->database->name
   )
);
$conn->setAttribute("use_native_enum", TRUE)
->setAttribute("autoload_table_classes", TRUE);

if ($config->server->profile) {
    ini_set('max_execution_time', 0);

    $profiler = new Doctrine_Connection_Profiler();
    $conn->setListener($profiler);
}
Zend_Registry::set("connection", $conn);
unset($conn);

// Кэш
Zend_Registry::set(
    "cache",
    Zend_Cache::factory(
        "Core",
        $config->cache->backend,
        $config->cache->frontend->toArray(),
        $config->cache->{$config->cache->backend}->toArray()
   )
);
Zend_Registry::set(
    "cache_output",
    Zend_Cache::factory(
        "Outputx",
        $config->cache->backend,
        $config->cache->frontend->toArray(),
        $config->cache->{$config->cache->backend}->toArray()
   )
);

// Сессии и аутентификация
if ( WORKING_IN_BROWSER) {
    Zend_Session::setSaveHandler(new Zend_Session_SaveHandler_Cache(new Zend_Session_SaveHandler_DbTable(array(
        "name"              => "sessions",
        "primary"           => "id",
        "modifiedColumn"    => "modified",
        "dataColumn"        => "data",
        "lifetimeColumn"    => "lifetime",
        "lifetime"          => SESSION_LIFETIME,
        "db"                => Zend_Db::factory("Pdo_Mysql", array(
            "host"      => $config->database->hostname,
            "username"  => $config->database->username,
            "password"  => $config->database->password,
            "dbname"    => $config->database->name,
       )),
   )), Zend_Registry::get("cache")));
    Zend_Session::start(array(
        "name"          => "PHPSESS",
        "cookie_domain" => ("localhost" == $config->web->hostname) ? "localhost" : ("." . $config->web->hostname),
        "cookie_secure" => FALSE,
   ));
} else {
    Zend_Session::start();
}

Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage());

// Настройка MVC
Zend_Controller_Front::getInstance()
    ->setControllerDirectory( ROOT . '/application/controllers' )

    // переопределяем плагин ErrorHandler с тем, чтобы контроллер был не «error», а «errors» — это позволит использовать его как ErrorDocument в настройках Apache
    ->registerPlugin( new Zend_Controller_Plugin_ErrorHandler( array( "controller" => "errors" ) ), 100 )
    ->registerPlugin( new Zend_Controller_Plugin_TrackPreviousPage() )
    ->registerPlugin( new Zend_Controller_Plugin_PlanetDetector() )
;

// устанавливаем правильный код редиректа
$redirector = new Zend_Controller_Action_Helper_Redirector;
$redirector->setCode(303);
Zend_Controller_Action_HelperBroker::addHelper($redirector);
unset($redirector);

Zend_Layout::startMvc();
Zend_Layout::getMvcInstance()
    ->setLayoutPath(ROOT . "/application/views/layouts")
    ->setLayout( User_Proxy::getInstance()->isRegistered() ? "default" : "not-authorized")
    ->getView()
        ->setScriptPath(ROOT . "/application/views/scripts")
        ->addHelperPath(ROOT . "/application/views/helpers")
        ->setEncoding("UTF-8")
        ->setEscape("html_escape")
        ->doctype("XHTML1_STRICT")
;

set_include_path( ROOT . '/application/controllers' .
                  ROOT . '/application/default/controllers' .
                  PATH_SEPARATOR . get_include_path() );

require_once ROOT . "/application/routes.php";

// Локаль
mb_internal_encoding("UTF-8");
Zend_Registry::set("locale", new Zend_Locale("ru"));

// Отправка почты
Zend_Mail::setDefaultTransport(
    new Zend_Mail_Transport_Smtp($config->email->smtp->server, $config->email->smtp->toArray())
);

// Lucene
Zend_Search_Lucene_Analysis_Analyzer::setDefault(new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8Num_CaseInsensitive_BukvaYo());
Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding("UTF-8");
