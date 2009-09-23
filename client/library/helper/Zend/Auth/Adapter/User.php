<?php
class Zend_Auth_Adapter_User implements Zend_Auth_Adapter_Interface {
    private $user;

    public function __construct($user) {
        $this->user = $user;
    }

    public function authenticate() {
        if ($this->user) {
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $this->user);
        } else {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, NULL);
        }
    }
}