<?php
class IndexController extends Zend_Controller_Action {

    public function indexAction() {
        $this->view->user = Zend_Auth::getInstance()->getIdentity();


        if ( !User_Proxy::getInstance()->isRegistered() ) {
            $this->render("not-authorized");
            return;
        }
    }

}