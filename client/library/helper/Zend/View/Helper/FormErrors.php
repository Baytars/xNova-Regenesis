<?php
class Zend_View_Helper_FormErrors extends Zend_View_Helper_Abstract {

    public function formErrors($errors, $options) {
        return '<span class="errors"><nobr>'.implode(",", $errors)."</nobr></span>";
    }

}