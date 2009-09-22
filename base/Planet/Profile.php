<?php
class Planet_Profile extends Record {

    public function setTableDefinition() {
        $this->setTableName("planet_profiles");

        $this->hasIdColumn();
        $this->hasReferenceColumn("image_id");

        $this->hasColumn("fields_count", "integer", array(
            "unsigned" => TRUE,
            "default" => 0
        ) );

        $this->hasColumn("max_temperature", "integer", array(
            "notnull" => TRUE
        ) );

        $this->hasColumn("min_temperature", "integer", array(
            "notnull" => TRUE
        ) );

        $this->hasColumn("diameter", "integer", array(
            "unsigned" => TRUE,
            "notnull" => TRUE
        ) );

    }

    public function setUp() {
        $this->hasOne("Image as image", array(
            "local" => "image_id",
            "foreign" => "id",
            "onDelete" => "SET NULL"
        ) );

        $this->hasMany("Planet as planets", array(
            "local" => "id",
            "foreign" => "profile_id"
        ) );
    }

    public function getDiameter() {
        return $this->diameter;
    }

    public function getMaxTemperature() {
        return $this->max_temperature;
    }

    public function getMinTemperature() {
        return $this->min_temperature;
    }

    public function getType() {
        return $this->type;
    }

    public function getFieldsCount() {
        return $this->fields_count;
    }

}

class Planet_ProfileTable extends Table {


}