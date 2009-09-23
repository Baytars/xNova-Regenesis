<?php
class Zend_Validate_Password extends Zend_Validate_Abstract {

    private $length_validator;

    public function __construct() {
        $this->length_validator = new Zend_Validate_StringLength(6);
    }

    public function isValid($value) {
        $this->_setValue($value);

        $valid = TRUE;

        if( !$this->length_validator->setTranslator($this->getTranslator())->isValid($value) ) {
            foreach($this->length_validator->getMessages() as $message) {
                $this->_messages[] = $message;
            }
            foreach($this->length_validator->getErrors() as $error) {
                $this->_errors[] = $error;
            }
            $valid = FALSE;
        }

        return $valid;
    }
}