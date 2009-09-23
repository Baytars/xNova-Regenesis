<?php
/**
 * Таблица для хранения сессий
 */
class Zend_Session_Storage extends Record {
    public function setTableDefinition() {
        $this->setTableName("sessions");
        $this->hasColumn("id", "string", array("length" => LENGTH_MD5, "primary" => TRUE));
        $this->hasColumn("modified", "integer", array("unsigned" => TRUE));
        $this->hasColumn("lifetime", "integer", array("unsigned" => TRUE));
        $this->hasColumn("data", "string", array("length" => LENGTH_DATA));
    }
}

class Zend_Session_StorageTable extends Doctrine_Table {
}