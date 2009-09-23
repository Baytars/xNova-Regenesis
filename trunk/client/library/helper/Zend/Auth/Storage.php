<?php
class Zend_Auth_Storage implements Zend_Auth_Storage_Interface {
    protected $session;
    protected $user;

    public function __construct() {
        $this->session = new Zend_Session_Namespace("UserAuth");
    }

    public function isEmpty() {
        return !isset($this->session->user_id);
    }

    public function read() {
        if (empty($this->user)) {
            $this->user = Doctrine::getTable("User")->find($this->session->user_id);
        }
        return $this->user;
    }

    public function write($user) {
        if (! $user instanceof User) {
            throw new Zend_Auth_Exception("Параметр Zend_Auth_Storage::write должен быть объектом User");
        }
        Zend_Session::rememberMe(YEAR);
        $this->session->user_id = $user->id;
    }

    public function clear() {
        $this->user = NULL;
        unset($this->session->user_id);
    }

    public function setOpenId($openid, $sreg = NULL) {
        $this->session->openid = $openid;
        $this->session->openid_sreg = $sreg;
    }

    public function getOpenId() {
        return $this->session->openid;
    }

    public function getOpenIdSreg() {
        return $this->session->openid_sreg;
    }
}