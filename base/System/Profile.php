<?php
class System_Profile extends Record {

    public function setTableDefinition() {
        $this->setTableName("system_profiles");

        $this->hasIdColumn();
        $this->hasReferenceColumn("image_id");
        $this->hasColumn("name", "string", array(
            "notnull" => TRUE
        ) );
    }

    public function setUp() {
        $this->hasOne("Image as image", array(
            "local" => "image_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );

        $this->hasMany("System as systems", array(
            "local" => "id",
            "foreign" => "profile_id"
        ) );
    }

    public function getName() {
        return $this->name;
    }

}

class System_ProfileTable extends Table {
    
}