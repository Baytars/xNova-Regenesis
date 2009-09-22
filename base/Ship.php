<?php
class Ship extends Buildable_Object {

    public function setTableDefinition() {
        parent::setTableDefinition();

        $this->setTableName("ships");
        $this->hasReferenceColumn("profile_id", TRUE);
        $this->hasReferenceColumn("planet_id", TRUE);
        $this->hasColumn("count", "integer", array(
            "unsigned" => TRUE,
            "default" => 0
        ) );
        
    }

    public function setUp() {
        parent::setUp();

        $this->hasOne("Ship_Profile as profile", array(
            "local" => "profile_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );

        $this->hasOne("Planet as planet", array(
            "local" => "planet_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );

        $this->hasMany("Dependency_Building as dependency_buildings", array(
            "local" => "id",
            "foreign" => "subject_id"
        ) );

        $this->hasMany("Dependency_Technology as dependency_technologies", array(
            "local" => "id",
            "foreign" => "subject_id"
        ) );
    }

    public function getWeapons() {
        return $this->getProfile()->weapons;
    }

    public function getDefences(){
        return $this->getProfile()->defences;
    }

    public function getName() {
        return $this->getProfile()->getName();
    }

    public function getProfile() {
        return $this->profile;
    }
    
    public function getCount() {
        return $this->count;
    }
}