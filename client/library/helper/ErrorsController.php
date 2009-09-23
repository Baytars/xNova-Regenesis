<?php
class ErrorsController extends Zend_Controller_Action {

    public function errorAction() {
        try {
            $this->_helper->getHelper( 'ContextSwitch' )
                ->addActionContext( 'error', 'json')
                ->initContext();      //Если запрос на json - отдаём json

            $this->view->clearVars(); //Если view до этого что-то успели написать
            $error = $this->_request->error_handler;

            if( $this->_helper->contextSwitch->getCurrentContext() != 'json' ) {
                switch ($error->type) {
                    case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
                    case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                        if (Zend_Registry::get("config")->server->development) {
                            Zend_Registry::get("log")->warn("Page not found: " . $_SERVER["REQUEST_URI"]);
                        }
                        $this->_forward("page-not-found");
                        break;
                    default:
                        if (!empty($error->exception)) {
                            $this->view->message = $error->exception->getMessage();
                            $this->handleException($error->exception);
                            if ($error->exception instanceof PageException_AuthRequired) {
                                $this->_forward("auth-required");
                                return;
                            } elseif ($error->exception instanceof PageException_AccessDenied) {
                                $this->_forward("access-denied");
                                return;
                            } elseif ($error->exception instanceof PageException_NotFound) {
                                $this->_forward("page-not-found");
                                return;
                            }
                        }
                        $this->_forward("other-error");
                }
            } else {
                // JSON-запрос
                $this->view->result = FALSE;
                if (!empty($error->exception)) {
                    $this->view->message = $error->exception->getMessage();
                }
            }
        } catch (Exception $e) {
            if (Zend_Registry::get("config")->server->development) {
                die("Error in ErrorController (sic) - {$e->getFile()}, line {$e->getLine()}: {$e->getMessage()}");
            } else {
                $this->_forward("other-error");
            }
        }
    }

    public function authRequiredAction() {
        if( !$this->_request->isXmlHttpRequest() ) {
            $this->_redirect("/auth/login/?return_to=" . urlencode($_SERVER["REQUEST_URI"]));
        }
    }

    public function accessDeniedAction() {
        $this->getResponse()->setHttpResponseCode(403);
    }

    public function pageNotFoundAction() {
        $this->getResponse()->setHttpResponseCode(404);
    }

    public function otherErrorAction() {
        $this->getResponse()->setHttpResponseCode(500);
    }

    /** @var array эквиваленты стандартных уровней ошибок PHP уровням журнала Zend */
    protected static $zend_level = array(
        E_ERROR             => Zend_Log::ERR,
        E_WARNING           => Zend_Log::WARN,
        E_PARSE             => Zend_Log::ERR,
        E_NOTICE            => Zend_Log::NOTICE,
        E_CORE_ERROR        => Zend_Log::CRIT,
        E_CORE_WARNING      => Zend_Log::WARN,
        E_COMPILE_ERROR     => Zend_Log::CRIT,
        E_COMPILE_WARNING   => Zend_Log::WARN,
        E_USER_ERROR        => Zend_Log::ERR,
        E_USER_WARNING      => Zend_Log::WARN,
        E_USER_NOTICE       => Zend_Log::NOTICE,
        E_STRICT            => Zend_Log::NOTICE,
        E_RECOVERABLE_ERROR => Zend_Log::ERR,
    );

    /** @var array названия разных уровней журнала Zend */
    protected static $level_names = array(
        Zend_Log::DEBUG     => "Debug",
        Zend_Log::INFO      => "Info",
        Zend_Log::NOTICE    => "Notice",
        Zend_Log::WARN      => "Warning",
        Zend_Log::ERR       => "Error",
        Zend_Log::CRIT      => "Critical error",
        Zend_Log::ALERT     => "Achtung",
        Zend_Log::EMERG     => "Emergency",
    );

    /**
     * Определить уровень журнала Zend по уровню ошибки PHP
     * @param int $level уровень ошибки PHP
     * @return int уровень журнала Zend
     */
    protected static function getZendLevel($level) {
        if (isset(self::$zend_level[$level])) {
            $log_level = self::$zend_level[$level];
        } else {
            Zend_Registry::get("log")->warn("Неизвестный уровень ошибки PHP: {$level}");
            $log_level = Zend_Log::ERR;
        }
        return $log_level;
    }

    public static function handleError($level, $message, $file, $line) {
        if (!error_reporting()) {
            return;
        }
        if (substr($file, -16) === DIRECTORY_SEPARATOR . "Zend" . DIRECTORY_SEPARATOR . "Loader.php") {
            return;
        }
        if (strpos($message, "Please use the date.timezone setting") !== FALSE) {
            return;
        }
        if (strpos($file, DIRECTORY_SEPARATOR . "library" . DIRECTORY_SEPARATOR . "Auth" . DIRECTORY_SEPARATOR) !== FALSE) {
            return;
        }
        if (strpos($message, "iconv") !== FALSE) {
            return;
        }
        if ((substr($file, -17) === "Xmpp" . DIRECTORY_SEPARATOR . "HttpBind.php") && (strpos($message, "DOMDocument::loadXML") !== FALSE)) {
            return;
        }

        Zend_Registry::get("log")->log("$message in $file, line $line", $zend_level = self::getZendLevel($level));
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $is_xmlhttp = $request instanceof Zend_Controller_Request_Http && $request->isXmlHttpRequest();
        if (!$is_xmlhttp && Zend_Registry::get("config")->server->development) {
            if (!isset( $_SERVER["REMOTE_ADDR"])) { // при консольном выполнении выбрасываем исключение — чтобы падали тесты и т. п.
                throw new PhpError("$message in $file, $line");
            }
            self::showError(self::$level_names[$zend_level], "", $message, $file, $line);
        }
    }

    public static function handleException($exception) {
        $name = get_class($exception);
        if ($code = $exception->getCode()) {
            $name .= " ($code)";
        }
        $message = $exception->getMessage();
        if ($exception instanceof Zend_Controller_Dispatcher_Exception) {
            $message .= " Request URI: " . $_SERVER["REQUEST_URI"];
        }
        $file = $exception->getFile();
        $line = $exception->getLine();
        Zend_Registry::get("log")->err("Exception $name: $message in $file, line $line");

        $request = Zend_Controller_Front::getInstance()->getRequest();
        $is_xmlhttp = $request instanceof Zend_Controller_Request_Http && $request->isXmlHttpRequest();
        if (!$is_xmlhttp && Zend_Registry::get("config")->server->development) {
            if ($exception instanceof PageException_AuthRequired) {
                print "<p>Нужно <a href='/auth/login/?return_to=" . urlencode($_SERVER["REQUEST_URI"]) . "'>залогиниться</a>.</p>";
                return;
            }
            self::showError("Exception", $name, $message, $file, $line);
        }
    }

    private static function showError($title, $name, $message, $file, $line) {
        if (isset($_SERVER["REMOTE_ADDR"])) { // если это HTTP-запрос
            $message    = htmlspecialchars($message);
            $file       = htmlspecialchars($file);
            print "\n<div class='devel_error'>
                    <p>$title <strong>$name</strong></p>
                    <p style='color: red'>$message</p>
                    <p>
                        <input type='text' value='$file' size='100' />
                        line <span style='color: blue'>$line</span>
                    </p>
                </div>\n";

            if ( !empty( Zend_Registry::get( "config" )->debug->print_backtrace ) ) {
                print "<pre class='devel_error'>\n";
                debug_print_backtrace();
                print "</pre>\n";
            }
        } else { // если выполнение из консоли
            $title = strtoupper($title);
            print "\n$title $name: $message in $file, line $line\n";
            if ( !empty( Zend_Registry::get( "config" )->debug->print_backtrace ) ) {
                debug_print_backtrace();
            }
        }
    }
}

class PhpError extends Exception {}