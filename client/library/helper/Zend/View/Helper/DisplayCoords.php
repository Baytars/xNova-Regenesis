<?php
class Zend_View_Helper_DisplayCoords extends Zend_View_Helper_Abstract {

    public function displayCoords( array $coords ) {
        return join(":", $coords);
    }

}