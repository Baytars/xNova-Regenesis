<?php
class BuildingsController extends Zend_Controller_Action {

    public function init() {
        $this->user = User_Proxy::getInstance();
    }

    public function technologiesAction() {
        $planet = $this->getFrontController()->getPlugin("Zend_Controller_Plugin_PlanetDetector")->getCurrent();
        if ( !$planet ) {
            $this->_redirect("/");
        }
        
        $this->view->technologies = Doctrine::getTable("Technology")->findAll();
        $this->view->planet = $planet;
        $this->view->user = $this->user;
    }

    public function indexAction() {
        $planet = $this->getFrontController()->getPlugin("Zend_Controller_Plugin_PlanetDetector")->getCurrent();
        if ( !$planet ) {
            $this->_redirect("/");
        }

        // @TODO replace with pager and cache
        $this->view->buildings = Doctrine::getTable("Building")->findAll();
        $this->view->user = $this->user;
        $this->view->planet = $planet;
    }

    public function buildAction() {
        if ( $this->_request->isPost() ) {
            $planet = $this->getFrontController()->getPlugin("Zend_Controller_Plugin_PlanetDetector")->getCurrent();
            if ( !$planet ) {
                throw new PageException_NotFound;
            }
            
            if ( $planet->getUser()->getId() != $this->user->getId() ) {
                throw new PageException_AccessDenied;
            }

            $building = Doctrine::getTable("Building")->find( intval( $this->_request->id ) );
            if ( !$building ) {
                throw new PageException_NotFound("Building not exists");
            }

            if ( $planet->canBuild( $building, $this->user ) ) {
                foreach( $building->getResourceAmounts() as $resource_amount ) {
                    $this->user->useResource( $resource_amount->getAmount(), $resource_amount->getResource() );
                }

                if ( $planet->hasBuilding( $building ) ) {
                    $planet->upgradeBuilding( $building );
                } else {
                    $planet->addBuilding( $building );
                }
            } else {
                throw new PageException_AccessDenied;
            }

            $this->_redirect( "infrastructure/" . $planet->getId() );
        }
        
        $this->_redirect("/");
    }

}