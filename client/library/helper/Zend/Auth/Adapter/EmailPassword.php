<?php
/**
 * Адаптер для аутентификации с помощью логина и пароля
 *
 * @ingroup Extensions
 */
class Zend_Auth_Adapter_EmailPassword implements Zend_Auth_Adapter_Interface {

    private $email;
    private $password;

    public function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function authenticate() {
        $user = Doctrine::getTable("User")->findOneByEmail($this->email);

        if ($user) {
            if ($user->checkPassword($this->password)) {
                return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $user);
            } else {
                return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, NULL);
            }
        } else {
            return new Zend_Auth_Result(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, NULL);
        }
    }
}
