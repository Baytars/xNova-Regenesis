<?php
class System extends Record {

    public function setTableDefinition() {
        $this->setTableName("systems");

        $this->hasIdColumn();
        $this->hasReferenceColumn("user_id", TRUE );
        $this->hasReferenceColumn("galaxy_id", TRUE );
        $this->hasReferenceColumn("profile_id", TRUE );
        $this->hasColumn("level", "integer", array(
            "unsigned" => TRUE,
            "default" => 0
        ) );
    }

    public function setUp() {
        $this->hasOne("User as user", array(
            "foreign" => "id",
            "local" => "user_id",
            "onDelete" => "CASCADE"
        ) );

        $this->hasOne("System_Profile as profile", array(
            "foreign" => "id",
            "local" => "profile_id",
            "onDelete" => "CASCADE"
        ) );

        $this->hasOne("Galaxy as galaxy", array(
            "foreign" => "id",
            "local" => "galaxy_id",
            "onDelete" => "CASCADE"
        ) );

        $this->hasMany("Planet as planets", array(
            "foreign" => "system_id",
            "local" => "id"
        ) );
    }

    public function create() {
        $this->save();
        
        $this->newPlanet( $this->getUser()->getEmpireName(), Doctrine::getTable("Planet_Profile")->getRandom() );
    }

    public function setUser( User $user ) {
        $this->user = $user;
        return $this;
    }

    public function getUser() {
        return $this->user;
    }

    public function setProfile( System_Profile $profile ) {
        $this->profile = $profile;
        return $this;
    }

    public function getProfile() {
        return $this->profile;
    }

    public function setName( $value ) {
        $this->name = $value;
        return $this;
    }

    public function getName() {
        return $this->profile->getName();
    }

    public function newPlanet( $name, Planet_Profile $profile ) {
        $planet = Doctrine_Query::create()->from("Planet")
                                     ->where("name = ? AND system_id = ?", array( $name, $this->getId() ) )
                                     ->limit(1)
                                     ->fetchOne();
        if ( $planet ) {
            throw new Exception("Planet {$name} alredy exists");
        }

        $planet = new Planet();
        $planet->create( $name, $this, $profile );

        return $planet;
    }

    public function getPlanets() {
        return $this->planets;
    }

    public function setGalaxy( Galaxy $galaxy ) {
        $this->galaxy = $galaxy;
        return $this;
    }

    public function getGalaxy() {
        return $this->galaxy;
    }

}