<?php
/**
 * Элемент формы для выбора города в заданной области (регионе).
 * Принимает в качестве параметра "region" объект Geographic_Region, для которого выбирается город.
 *
 * @ingroup Forms
 *
 */
class Zend_Form_Element_City extends Zend_Form_Element_Select {

    private static $cities;
    private $region;

    public function __construct($spec, $options = NULL) {
        $region = ifsetor($options['region'], NULL);
        if( is_int($region) || is_string($region) ) {
            $region = Doctrine::getTable("Geographic_Region")->find($region);
        }
        unset($options['region']);
        unset($options['multiOptions']);
        $options["class"] = ifsetor($options["class"], "").' select_city';
        parent::__construct($spec, $options);
        if ($region instanceof Geographic_Region) {
            $this->setRegion($region);
        }
    }

    /**
     * Установить регион, в котором выбирается город
     *
     * @param Geographic_Region $region
     */
    public function setRegion(Geographic_Region $region) {
        $this->region = $region;
        $this->setMultiOptions($this->getList());
        return $this;
    }

    public function refresh() {
        $this->refreshLists();
        $this->region->refresh(TRUE);
        $this->setRegion($this->region);
    }

    /**
     * @param Geographic_City | string $value
     */
    public function setValue($value) {
        return parent::setValue($value instanceof Geographic_City ? $value->id : $value);
    }

    /**
     * Обновить список городов
     */
    public static function refreshLists() {
        //Просто устанавливаем в NULL - загрузим при следующем запуске
        self::$cities = NULL;
    }


    public function isValid($value, $context = null) {
        $this->setValue($value);

        $this->_messages = array();
        $this->_errors = array();

        $result = Doctrine::getTable("Geographic_City")->find( intval( $value ) );
        $_isValid = !$this->isRequired() || $result;
        if ( !$_isValid ) {
            $this->_messages [] = "Регион не найден!";
        }

        return $_isValid;
    }

    /**
     * Возвращает список возможных городов
     *
     * @return array
     */
    private function getList() {
        if( empty($this->region) ) {
            return array();
        }
        if( !isset(self::$cities[$this->region->id]) ) {
            $db_cities = $this->region->cities;
            $main_city = array();
            $result = array();
            foreach($db_cities as $city) {
                if ($this->region->getCapital() != $city) {
                    $result[$city->id] = $city->getName();
                } else {
                    $main_city[$city->id] = $city->getName();
                }
            }
            self::$cities[$this->region->id] = array(" " => " ") + ((!empty($main_city))? $main_city+$result : $result);
        }
        return self::$cities[$this->region->id];
    }
}