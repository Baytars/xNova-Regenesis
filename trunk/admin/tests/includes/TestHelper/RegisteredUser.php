<?php
/** Хелпер для тестов, где требуется зарегистрированный пользователь */
class TestHelper_RegisteredUser {
    /** @var User */
    private $user;

    /**
     * Создаёт пользователя
     */
    public function __construct() {
        $this->user = new User();
        $this->user->create("t" . (mt_rand() % 10000) . "est" . (time() % 10000) . "@gmail.com", md5(mt_rand()));
    }

    /** Пользователь автоматически удаляется при деструкции, нет нужды делать это вручную */
    public function __destruct() {
        $this->logout();
        $this->user->delete();
    }

    /** Аутентифицировать пользователя */
    public function login() {
        Zend_Auth::getInstance()->clearIdentity(); // just in case
        Zend_Auth::getInstance()->authenticate(new TestHelper_Auth($this->user));
    }

    /** Разлогиниться */
    public function logout() {
        Zend_Auth::getInstance()->clearIdentity();
    }

    //// Доступ к собственно пользователю может осуществляться явно посредством метода themselves или неявно при помощи волшебных методов ////

    /**
     * Доступ к пользователю
     * @return User
     */
    public function themselves() {
        return $this->user;
    }

    public function __call($method, array $arguments) {
        return call_user_func_array(array($this->user, $method), $arguments);
    }

    public function __callStatic($method, array $arguments) {
        return call_user_func_array(array(get_class($this->user), $method), $arguments);
    }

    public function __get($property) {
        return $this->user->$property;
    }

    public function __set($property, $value) {
        $this->user->$property = $value;
    }

    public function __isset($property) {
        return isset($this->user->$property);
    }

    public function __unset($property) {
        unset($this->user->$property);
    }
}