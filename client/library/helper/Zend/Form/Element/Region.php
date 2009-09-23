<?php
/**
 * Элемент формы для выбора области (региона)
 *
 * В качестве параметра (в массиве $options) может передаваться объект класса Geographic_Country,
 * для которого выбирается регион.
 *
 * @ingroup Forms
 */
class Zend_Form_Element_Region extends Zend_Form_Element_Select {

    private $country;
    private static $regions;

    public function __construct($spec, $options = NULL) {
        $country = ifsetor($options['country'], NULL);
        if( is_int($country) || is_string($country) ) {
            $country = Doctrine::getTable("Geographic_Country")->find($country);
        }
        unset($options['country']);
        unset($options['multiOptions']);
        $options["class"] = ifsetor($options["class"], "").' select_region';
        parent::__construct($spec, $options);
        if ($country instanceof Geographic_Country) {
            $this->setCountry($country);
        }
    }

    public function isValid($value, $context = null) {
        $this->setValue($value);

        $this->_messages = array();
        $this->_errors = array();

        $result = Doctrine::getTable("Geographic_City")->find( intval( $value ) );
        $_isValid = !$this->isRequired() || $result;
        if ( !$_isValid ) {
            $this->_messages [] = "Город не найден!";
        }

        return $_isValid;
    }


    private function getList() {
        if( empty($this->country) ) {
            return array();
        }
        if( !isset(self::$regions[$this->country->id]) ) {
            $result = array();
            $db_regions = $this->country->regions;
            foreach($db_regions as $region) {
                #print $region->id.':'.$region->getName()."<br/>";
                $result[$region->id] = $region->getName();
            }

            self::$regions[$this->country->id] = array(" " => " ") + $result;
        }
        asort(self::$regions[$this->country->id]);


        return self::$regions[$this->country->id];
    }

    public static function refreshLists() {
        self::$regions = NULL;
    }

    public function setCountry(Geographic_Country $country) {
        $this->country = $country;
        $this->setMultiOptions($this->getList());
        return $this;
    }

    public function setValue($value) {
        return parent::setValue($value instanceof Geographic_Region ? $value->id : $value);
    }

}