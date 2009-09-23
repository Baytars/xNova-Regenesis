<?php
/**
 * Для автолоада классов коллекций (Doctrine_Table), которые описываются в тех же файлах, что и модели
 */
class Zend_Loader_Autoloader_RecordTable implements Zend_Loader_Autoloader_Interface {
    public function autoload($table_class) {
        if (substr($table_class, -5) == "Table") {
            return class_exists(substr($table_class, 0, -5), TRUE);
        } else {
            return FALSE;
        }
    }
}