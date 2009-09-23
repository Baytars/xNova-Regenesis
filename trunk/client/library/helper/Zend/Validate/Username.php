<?php
class Zend_Validate_Username extends Zend_Validate_Abstract {
    const ALREADY_EXISTS    = "Пользователь с таким именем уже существует";
    const WRONG_LENGTH      = "Недопустимая длина имени пользователя";
    const PROHIBITED        = "Использование этого имени пользователя запрещено";

    private static $PROHIBITED_USERNAMES = array(
        "admin",
        "blog",
        "dev",
        "forum",
        "ftp",
        "img",
        "jabber",
        "xmpp",
        "lab",
        "mail",
        "metaid",
        "news",
        "ns1",
        "ns2",
        "ns3",
        "ns4",
        "openid",
        "pda",
        "profile",
        "profiles",
        "root",
        "sonic",
        "ssh",
        "ssl",
        "static",
        "support",
        "svn",
        "team",
        "test",
        "tools",
        "www",
        "web",
        "wap",
        "xmpp",
        "pop",
        "pop3",
        "smtp",
        "imap",
        "president",
        "ufo",
        "fsb",
        "xxx",
    );

    private $except;

    protected $_messageTemplates = array(
        self::ALREADY_EXISTS    => "Пользователь с таким именем уже существует",
        self::WRONG_LENGTH      => "Недопустимая длина имени пользователя",
        self::PROHIBITED        => "Использование этого имени пользователя запрещено",
    );

    /**
     *
     * @param string $except - значение, которое не нужно проверять и которое всегда проходит (например, если это текущее имя)
     */
    public function __construct($except = NULL) {
        $this->except = $except;
        $this->_messageTemplates[self::WRONG_LENGTH] = sprintf(
            _("Недопустимая длина имени пользователя. Она должна быть от %1\$d до %2\$d символов"),
            LENGTH_USERNAME_MIN,
            LENGTH_USERNAME_MAX
        );
    }

    public function isValid($value) {
        $this->_setValue($value);

        if( $this->except && $value === $this->except ) {
            return TRUE;
        }

        if (strlen($value) > LENGTH_USERNAME_MAX || strlen($value) < LENGTH_USERNAME_MIN) {
            $this->_error(self::WRONG_LENGTH);
            return FALSE;
        }

        if( in_array($value, self::$PROHIBITED_USERNAMES) ) {
            $this->_error(self::PROHIBITED);
            return FALSE;
        }

        return TRUE;
    }
}