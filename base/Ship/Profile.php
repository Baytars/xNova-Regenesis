 <?php
class Ship_Profile extends Record {

    public function setTableDefinition() {
        $this->setTableName("ship_profiles");

        $this->hasIdColumn();
        $this->hasColumn("name", "string", array(
            "length" => LENGTH_NAME,
            "notnull" => TRUE
        ) );

        $this->hasColumn("rating_points", "integer", array(
            "unsigned" => TRUE,
            "default" => 1
        ) );
    }

    public function setUp() {
        $this->hasMany("Resource_Amount as resource_amounts", array(
            "local" => "id",
            "foreign" => "subject_id"
        ) );
        
        $this->hasMany("Ship_Part as parts", array(
            "local" => "id",
            "foreign" => "ship_id"
        ) );
    }

    public function getWeapon() {
        return $this->weapon;
    }

    public function getDefence() {
        return $this->defence;
    }

    public function getName() {
        return $this->name;
    }

    public function getResourceAmounts() {
        return $this->resource_amounts;
    }
}