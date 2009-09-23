<?php
class Zend_Validate_RegisteredUser extends Zend_Validate_Username {


    public function isValid( $value ) {
        $value = parent::isValid($value);

        if ( $value ) {
            return Doctrine::getTable("User")->findOneByNickname($value);
        } else {
            return $value;
        }
    }

}