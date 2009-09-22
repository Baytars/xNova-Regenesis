<?php
class FleetController extends Zend_Controller_Action {

    public function init() {
        $this->user = User_Proxy::getInstance();
    }

    public function indexAction() {
        $planet = $this->getFrontController()->getPlugin("Zend_Controller_Plugin_PlanetDetector")->getCurrent();
        if ( !$planet ) {
            throw new PageException_NotFound;
        }

        $this->view->planet = $planet;
    }

    public function shipAction() {
        $planet = $this->getFrontController()->getPlugin("Zend_Controller_Plugin_PlanetDetector")->getCurrent();
        if ( !$planet ) {
            throw new PageException_NotFound;
        }

        if ( $planet->getUser()->getId() != $this->user->getId() ) {
            throw new PageException_AccessDenied;
        }

        $ship = Doctrine::getTable("Ship")->find( intval( $this->_request->id ) );
        if ( !$ship ) {
            throw new PageException_NotFound;
        }

        $this->view->ship = $ship;
        $this->view->planet = $planet;
    }

    public function buildAction() {
        $planet = $this->getFrontController()->getPlugin("Zend_Controller_Plugin_PlanetDetector")->getCurrent();
        if ( !$planet ) {
            throw new PageException_NotFound;
        }

        $this->view->planet = $planet;
        $this->view->ships = Doctrine::getTable("Ship")->findAll();
    }
    

}