<?php
/**
 * User proxy to support guests and users using single entity
 */
class User_Proxy {
    private static $instance = null;

    /**
     * @return User_Proxy | User
     */
    public static function getInstance() {
        $identity = Zend_Auth::getInstance()->getIdentity();
        if ( $identity != NULL ) {
            return $identity;
        } else {
            if ( self::$instance == null ) {
                    self::$instance = new User_Proxy();
            }

            return self::$instance;
        }
    }

    public function isAdmin() {
        return FALSE;
    }

    public function isRegistered() {
        return FALSE;
    }
}
