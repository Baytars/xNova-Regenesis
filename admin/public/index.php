<?php
require_once realpath(dirname(__FILE__) . "/../bootstrap.php");

// роутинг ZF использует REQUEST_URI, тогда как нужный адрес отчего-то оказывается в REDIRECT_URL
if ( ! empty( $_SERVER[ 'REDIRECT_URL' ] ) ) {
    $_SERVER[ 'REQUEST_URI' ] = $_SERVER[ 'REDIRECT_URL' ];
    if ( ! empty($_SERVER[ 'QUERY_STRING' ] ) ) {
        $_SERVER[ 'REQUEST_URI' ] .= '?' . $_SERVER[ 'QUERY_STRING' ];
    }
}

// Диспач MVC
Zend_Controller_Front::getInstance()->dispatch();

if (Zend_Registry::get( "config" )->server->profile) {
    Zend_Debug::profile();
}