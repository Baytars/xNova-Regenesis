<?php
class Table extends Doctrine_Table {

    /*********************************************************************************
     * Делаем свою систему наследования. Т.к. мы не можем переопределить Record_Hydrator, то используем хак:
     * в функции getRecord используется $this->getComponentName()
     * Мы его переопределяем таким образом, чтобы он учитывал поле сабкласса и возвращал соответствующее значение.
     * Мы не переопределяем эту функцию в других случаях, чтобы избежать возможных багов.
     */
    private $overwrite_get_component_name = FALSE;

    public function getRecord() {
        $this->enableComponentNameHack();
        $record = parent::getRecord();
        $this->disableComponentNameHack();
        return $record;
    }

    public function getComponentName() {
        if(!$this->overwrite_get_component_name) {
            return parent::getComponentName();
        }
        if ( ! isset($this->_data[Record::SUBCLASS_FIELD])) {
            return $this->_options['name'];
        } else {
            return $this->_data[Record::SUBCLASS_FIELD];
        }
    }

    /*
     * Эта и следующая функции нужны, чтобы Record тоже мог участвовать в хаке
     */
    public function disableComponentNameHack() {
        $this->overwrite_get_component_name = FALSE;
    }

    public function enableComponentNameHack() {
        $this->overwrite_get_component_name = TRUE;
    }

    /************************************
     *    ОКОНЧАНИЕ ХАКА НАСЛЕДОВАНИЯ
     ************************************/

    public function getRandom() {
        $q = Doctrine_Query::create()->from( $this->getComponentName() )
                                     ->orderBy("RAND()")
                                     ->limit(1)
                                     ;
        return $q->fetchOne();
    }

}