<?php
class Galaxy extends Record {

    public function setTableDefinition() {
        $this->setTableName("galaxies");

        $this->hasIdColumn();
        $this->hasColumn("name", "string", array(
            "length" => LENGTH_NAME
        ) );
    }

    public function setUp() {
        $this->hasMany("System as systems", array(
            "local" => "id",
            "foreign" => "galaxy_id"
        ) );
    }

    public function getName() {
        return $this->name;
    }

    public function newSystem( System_Profile $profile ) {
        $system = new System();
        
        $system->setGalaxy( $this )
               ->setProfile( $profile );

        return $system;
    }

}