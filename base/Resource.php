<?php
class Resource extends Record implements Affectable {

    public function setTableDefinition() {
        $this->setTableName("resources");

        $this->hasIdColumn();
        $this->hasReferenceColumn("image_id");
        $this->hasColumn("name", "string", array(
            "length" => LENGTH_NAME,
            "notnull" => TRUE
        ));

        $this->hasColumn("description", "string", array(
            "length" => LENGTH_DESCRIPTION,
            "notnull" => TRUE
        ) );
    }

    public function setUp() {
        $this->hasOne("Image as image", array(
            "local" => "image_id",
            "foreign" => "id",
            "onDelete" => "SET NULL"
        ));
    }

    public function getType() {
        return Affectable::TYPE_RESOURCE;
    }

    public function getImage() {
        return $this->image;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

}
