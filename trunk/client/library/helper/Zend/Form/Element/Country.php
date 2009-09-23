<?php
/**
 * Элемент формы для выбора страны
 *
 * @ingroup Forms
 */
class Zend_Form_Element_Country extends Zend_Form_Element_Select {

    private static $countries;

    public function __construct($spec, $options = NULL) {
        $options['multiOptions'] = $this->getList();
        $options["class"] = ifsetor($options["class"], "").' select_country';
        parent::__construct($spec, $options);
    }

    protected function getList() {
        if( !isset(self::$countries) ) {
            $specials = array();
            $db_countries = Doctrine::getTable("Geographic_Country")->findAll();
            foreach($db_countries as $country) {
                if ($country->getName() != NULL) {
                    if ($country->position == NULL)
                        self::$countries[$country->id] = $country->getName();
                    else
                        $specials[$country->position] = array($country->id, $country->getName());
                }

            }
            asort(self::$countries);
            ksort($specials);

            $special = array();
            foreach ($specials as $country) {
                $special[$country[0]] = $country[1];
            }
            self::$countries = array(" " => " ") + $special + array("" => "------") + self::$countries;
        }
        return self::$countries;
    }

    /**
     * Обновить список городов
     */
    public static function refreshList() {
        //Просто устанавливаем в NULL - загрузим при следующем запуске
        self::$countries = NULL;
    }

    public function setValue($value) {
        return parent::setValue($value instanceof Geographic_Country ? $value->id : $value);
    }
}