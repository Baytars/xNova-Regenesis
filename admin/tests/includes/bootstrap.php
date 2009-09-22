<?php
define("TEST_ROOT", realpath(dirname(__FILE__) . "/.."));
define("TEST_DATA", TEST_ROOT . "/data");

require_once realpath(TEST_ROOT . "/../bootstrap.php");

set_include_path(get_include_path()
    . PATH_SEPARATOR . TEST_ROOT . "/includes/"
);

foreach (Doctrine_Manager::getInstance()->getConnections() as $_doctrine_connection) {
    Doctrine_Manager::getInstance()->closeConnection($_doctrine_connection);
    $_doctrine_connection = NULL;
}
Doctrine_Manager::connection(
    sprintf(
        "%s://%s:%s@%s/%s",
        $config->database->test->adapter,
        $config->database->test->username,
        $config->database->test->password,
        $config->database->test->hostname,
        $config->database->test->name
    )
)
->setAttribute("use_native_enum", TRUE)
->setAttribute("autoload_table_classes", TRUE);

Form::$DISABLE_AUTH_TOKEN = TRUE;
