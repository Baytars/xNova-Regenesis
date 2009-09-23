<?php
class Zend_Controller_Action_Helper_TrackPreviousPage extends Zend_Controller_Action_Helper_Abstract {
    /**
     * @var Zend_Controller_Plugin_TrackPreviousPage
     */
    protected $_trackPrevPage;
    
    public function __construct() {
        $front = Zend_Controller_Front::getInstance();
        if ( ! $front->hasPlugin( 'Zend_Controller_Plugin_TrackPreviousPage' ) ) {
            /**
             * @see Zend_Controller_Plugin_TrackPreviousPage
             */
            $this->_trackPrevPage = new Zend_Controller_Plugin_ActionStack();
            $front->registerPlugin( $this->_trackPrevPage );
            echo "NOT OK";
        } else {
            $this->_trackPrevPage = $front->getPlugin( 'Zend_Controller_Plugin_TrackPreviousPage' );
        }
    }
    
    /**
     * Perform helper when called as $this->_helper->TrackPreviousPage() from an action controller
     *
     * Proxies to {@link simple()}
     *
     * @param  string $action
     * @param  string $controller
     * @param  string $module
     * @param  array $params
     * @return boolean
     */
    public function direct() {
        return $this->_trackPrevPage;
    }
}