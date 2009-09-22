<?php
class PlanetController extends Zend_Controller_Action {

    public function init() {
        $this->user = User_Proxy::getInstance();
    }

    public function viewAction() {
        $planet = Doctrine::getTable("Planet")->find( intval( $this->_request->id ) );
        if ( !$planet ) {
            throw new PageException_NotFound;
        }

        if ( $planet->getUser()->getId() != $this->user->getId() ) {
            throw new PageException_AccessDenied;
        }

        $this->user->setCurrentPlanet( $planet );

        $this->view->planet = $planet;
    }

}