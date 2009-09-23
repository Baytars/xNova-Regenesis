<?php
class Zend_Controller_Plugin_PlanetDetector extends Zend_Controller_Plugin_Abstract {

    private $user;
    protected function getUser() {
        if ( !$this->user ) {
            $this->user = User_Proxy::getInstance();
        }

        return $this->user;
    }


    public function getCurrent( $var_name = "planet_id" ) {
        $planet = NULL;
        if ( isset( $this->_request->{$var_name} ) ) {
            $planet = Doctrine::getTable("Planet")->find( intval( $this->_request->planet_id ) );
        }

        if ( $this->getUser() ) {
            if ( !$planet ) {
                $planet = $this->getUser()->getCurrentPlanet();
            }
        }

        return $planet;
    }


}