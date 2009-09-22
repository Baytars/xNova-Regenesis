<?php
abstract class File extends Record {

    public function setTableDefinition() {
        $this->hasIdColumn();
        
        $this->hasColumn("path", "string", array(
            "notnull" => TRUE,
            "length" => LENGTH_PATH
        ) );
    
        $this->hasColumn("create_time", "integer", array(
            "notnull" => TRUE,
            "length" => LENGTH_UNIXTIMESTAMP
        ) );
    }

    public function getPath() {
        return $this->path;
    }

    public function setPath( $value ) {
        $this->path = $value;
    }

    public function create( array $fields, $save ) {
        $this->create_time = time();

        return parent::create( $fields, $save );
    }
    
}