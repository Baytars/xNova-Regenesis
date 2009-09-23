<?php
/**
 * Базовый класс для моделей, хранящихся в базе данных
 *
 * @ingroup Common
 */
abstract class Record extends Doctrine_Record {

    const SUBCLASS_FIELD = "type"; // Поле, в котором записывается класс текущей модели

    /**
     * Хак, который помогает с хаком наследования.
     * Если этого не сделать, запись не создаётся, т.к. думает, что таблица фейковая
     */
    public function __construct($table = null, $isNewEntry = false) {
        if($table && $table instanceof Table) {
            $table->disableComponentNameHack();
            parent::__construct($table, $isNewEntry);
            $table->enableComponentNameHack();
        } else {
            parent::__construct($table, $isNewEntry);
        }
    }

    public function hasColumn($name, $type, array $options = array()) {
        $length = isset($options["length"]) ? $options["length"] : NULL;
        unset($options["length"]);
        return parent::hasColumn($name, $type, $length, $options);
    }

    public function hasSubclasses($index_by_subclass = FALSE) {
        $this->hasColumn(self::SUBCLASS_FIELD, "integer");
        if($index_by_subclass) {
            $this->index(self::SUBCLASS_FIELD);
        }
    }

    public function hasIdColumn( $name = 'id' ) {
        return $this->hasColumn($name, "integer", array("unsigned" => TRUE, "length" => 20, "autoincrement" => TRUE, "primary" => TRUE));
    }

    public function hasReferenceColumn($name, $not_null = FALSE) {
        return $this->hasColumn($name, "integer", array("unsigned" => TRUE, "length" => 20, "notnull" => $not_null));
    }

    public function __set($key, $value) {
        $backtrace = debug_backtrace();

        /**
         * Если обновляемое поле является внешним ресурсом
         * или обновляется изнутри класса, то позволить прямое изменение
         */
        $self_class_name = __CLASS__;
        if ( !isset($this->_data[$key])
             || $backtrace[1]['object'] instanceof $self_class_name
             || $backtrace[1]['object'] instanceof Doctrine_Record_Listener ) {
            return parent::__set($key, $value);
        } else {
            throw new Exception("Setter available only from class body.");
        }
    }

    protected function create(array $data = NULL, $do_save = TRUE) {
        if( in_array(self::SUBCLASS_FIELD, $this->getTable()->getFieldNames()) ) {
            $data[self::SUBCLASS_FIELD] = get_class($this);
        }
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->$key = $value;
            }

            if ($do_save) {
                $this->save();
            }
        }

        return $this;
    }

    public function getId() {
        $pks = $this->identifier();
        return array_shift($pks);
    }

    /**
     * Преобразовывает дату и/или время в нормальный для Доктрины формат строки Y-m-d H:i:s
     * @param string|integer $value
     * @return string
     * @todo добавить поддержку Zend_Date, Datetime
     */
    public function normalizeDateTime($value) {
        if (is_numeric($value) && ((integer)$value == $value)) {
            return date("Y-m-d H:i:s", $value);
        }
        return $value;
    }
}