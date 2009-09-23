<?php
/**
 * Элемент формы "raw html"
 * Просто выводит своё значение
 *
 * @ingroup Forms
 */
class Zend_Form_Element_Raw extends Zend_Form_Element_Xhtml {
    public $helper = 'formRaw';

    protected $decorators = array();

    public function loadDefaultDecorators() {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator("ViewHelper", array("separator" => ""));
        }
    }

    public function isValid($value) {
        return TRUE;
    }
}
