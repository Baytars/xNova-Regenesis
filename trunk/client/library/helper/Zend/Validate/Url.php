<?php
class Zend_Validate_Url extends Zend_Validate_Abstract {
    private static $regexp;

    public static function initRegExp() {
        $protocol   = "((https?|ftps?|sftp)://|mailto:)";
        $username   = "[^:@]+";
        $password   = "[^@]+";
        $ipaddr     = "(\\d{1,3}\\.){3}\\d{1,3}";
        $domain     = "([a-z0-9][a-z0-9\\-]*\\.)+[a-z]{2,}";
        $hostname   = "($ipaddr|$domain)";
        $port       = "\\d+";
        $path       = "[^#\\?]+";
        $get        = "\\?[^#]*";
        $hash       = "#.*";

        self::$regexp = "!^($protocol($username(:$password)?@)?)?$hostname(:$port)?(/($path)?($get)?($hash)?)?$!i";
    }

    const WRONG_URL = "Неверный формат URL-адреса!";

    protected $_messageTemplates = array(
        self::WRONG_URL => "Неверный формат URL-адреса!"
    );

    public function isValid($value) {
        $this->_setValue($value);
        if (preg_match(self::$regexp, $value)) {
            return TRUE;
        } else {
            $this->_error(self::WRONG_URL);
            return FALSE;
        }
    }
}

Zend_Validate_Url::initRegExp();