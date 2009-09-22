<?php
class AuthController extends Zend_Controller_Action {
    public function init() {
        $this->user = User_Proxy::getInstance();

        $this->_helper->getHelper("AjaxContext")
                          ->addActionContext("login", "json")
                          ->addActionContext("register", "json")
                          ->init();
    }

    public function loginAction() {
        if ( $this->user->isRegistered() ) {
                $this->_redirect("/");
        }

        $form = new Form_Auth_Login();
        if ( $this->_request->isPost() ) {
            try {
                $this->_helper->formProcessor->process( $form, TRUE, "/" );
            } catch ( Exception $e ) {
                $this->view->errors = $form->getMessages();
            }
        }

        $this->view->form = $form;
    }

    public function logoutAction() {
        if ( $this->_request->isPost() ) {
                Zend_Auth::getInstance()->clearIdentity();
        }

        $this->_redirect( "/" );
    }

    public function registerAction() {
        if ( $this->user->isRegistered() ) {
            $this->_redirect( "/" );
        }

        $form = new Form_Auth_Register();
        if ( $this->_request->isPost() ) {
            try {
                $this->_helper->formProcessor->process($form, TRUE, "/");
            } catch ( Form_Exception $e ) {
                $this->view->errors = $form->getMessages();
            }
        }

        $this->view->form = $form;
    }
}