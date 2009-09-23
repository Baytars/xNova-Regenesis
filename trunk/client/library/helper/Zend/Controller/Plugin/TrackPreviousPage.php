<?php
class Zend_Controller_Plugin_TrackPreviousPage extends Zend_Controller_Plugin_Abstract {
    private $common_session;
    public function __construct() {
        $this->common_session = new Zend_Session_Namespace( "TrackPreviousPage" );
    }

    public function preDispatch( Zend_Controller_Request_Abstract $request ) {
        if ( ! $request->isXmlHttpRequest() ) {
            $this->common_session->prev_page = empty(  $this->common_session->current_page)
                ? "/"
                : $this->common_session->current_page;
            $parts = explode( ".", $_SERVER[ "REQUEST_URI" ] );
            if ( ! in_array( $parts[ count( $parts ) - 1 ], array( 'css', 'js', 'json' ) ) ) {
                $this->common_session->current_page = $_SERVER[ "REQUEST_URI" ];
            }
        }
    }

    public function getPrev() {
        return $this->common_session->prev_page;
    }
}