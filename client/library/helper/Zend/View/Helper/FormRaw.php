<?php
class Zend_View_Helper_FormRaw extends Zend_View_Helper_FormElement {
    public function formRaw($name, $value = NULL, $attribs = NULL)
    {
        $info = $this->_getInfo($name, $value, $attribs);
        extract($info); // name, value, attribs, options, listsep, disable

        if ( !empty($attribs["escape"]) && $attribs["escape"] ) {
            $value = $this->view->escape($value);
        }
        unset($attribs["escape"]);

        return $value;
    }
}