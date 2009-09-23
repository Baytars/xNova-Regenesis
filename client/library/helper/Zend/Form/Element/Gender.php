<?php
/**
 * Элемент формы для выбора пола.
 *
 * @ingroup Forms
 *
 */
class Zend_Form_Element_Gender extends Zend_Form_Element_Select {

    static private $GENDERS = array(
        User::GENDER_NULL => "Не указан",
        User::GENDER_MALE => "Мужчина",
        User::GENDER_FEMALE => "Женщина"
    );

    public function __construct($spec, $options = NULL) {
        $options["multiOptions"] = self::$GENDERS;
       
        parent::__construct($spec, $options);
    }
}