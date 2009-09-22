<?php
class User extends Record {

    private $current_planet;

    // creating table structure
    public function setTableDefinition() {
        $this->setTableName("users");

        $this->hasIdColumn();
        $this->hasReferenceColumn("galaxy_id", TRUE);
        $this->hasColumn("login", "string", array(
            "length" => LENGTH_NAME,
            "notnull" => TRUE
        ) );

        $this->hasColumn("password", "string", array(
            "length" => LENGTH_NAME,
            "notnull" => TRUE
        ) );

        $this->hasColumn("email", "string", array(
            "length" => LENGTH_NAME,
            "notnull" => TRUE
        ) );

        $this->hasColumn("empire_name", "string", array(
            "length" => LENGTH_NAME,
            "notnull" => TRUE
        ) );

        $this->hasColumn("is_admin", "boolean", array(
            "default" => FALSE
        ) );

        $this->hasColumn("registration_time", "integer", array(
            "length" => LENGTH_UNIXTIMESTAMP,
            "notnull" => TRUE
        ) );

        $this->hasColumn("update_time", "integer", array(
            "length" => LENGTH_UNIXTIMESTAMP,
            "notnull" => TRUE
        ) );

        $this->hasColumn("rating_points", "integer", array(
            "unsigned" => TRUE,
            "default" => 0
        ) );
    }

    public function save() {
        $this->update_time = time();

        if ( !$this->exists() ) {
            $this->registration_time = time();
        }

        return parent::save();
    }

    public function setUp() {
        $this->hasMany("System as systems", array(
            "local" => "id",
            "foreign" => "user_id"
        ) );

        $this->hasOne("Galaxy as galaxy", array(
            "local" => "galaxy_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );
    }

    public function create( $login, $email, $password, $empire_name, Galaxy $galaxy ) {
        parent::create( array(
            "login" => $login,
            "email" => $email,
            "password" => md5($password),
            "registration_time" => time(),
            "empire_name" => $empire_name,
            "galaxy" => $galaxy
        ) );

        $this->addSystem( Doctrine::getTable("System_Profile")->getRandom() )
             ->save();

        return $this;
    }

    public function setLogin( $login ) {
            $this->login = $login;
            return $this;
    }

    public function getLogin() {
            return $this->login;
    }

    public function setPassword( $value ) {
            $this->password = md5( $value );
            return $this;
    }

    public function checkPassword( $value ) {
        return $this->password = md5($value);
    }

    public function setEmail( $value ) {
        $this->email = $value;
        return $this;
    }

    public function getEmail() {
        return $this->email;
    }

    public function isRegistered() {
        return TRUE;
    }

    public function isAdmin() {
        return $this->is_admin;
    }

    public function setCurrentPlanet( Planet $planet ) {
        $this->getSession()->planet_id = $planet->getId();
        $this->current_planet = $planet;
        return $this;
    }

    public function getCurrentPlanet() {
        if ( !$this->current_planet ) {
            $this->current_planet = Doctrine::getTable("Planet")->find( intval( $this->getSession()->planet_id ) );
        }

        return $this->current_planet;
    }

    public function getGalaxy() {
        return $this->galaxy;
    }

    public function addSystem( System_Profile $profile ) {
        $system = $this->getGalaxy()->newSystem( $profile );

        $system->setUser( $this )
               ->create();

        return $this;
    }

    public function getSystems() {
        return $this->systems;
    }

    public function getPlanets() {
        $collection = new Doctrine_Collection("Planet");
        foreach( $this->getSystems() as $system ) {
            $collection->merge( $system->getPlanets() );
        }
        
        return $collection;
    }

    private $user_state;
    public function getState() {
        if ( !$this->user_state ) {
            $this->user_state = Doctrine::getTable("State")->getByUser( $this );
        }

        return $this->user_state;
    }

    private $session;
    protected function getSession() {
        if ( !$this->session ) {
            $this->session = new Zend_Session_Namespace("USER_SESSION");
        }

        return $this->session;
    }
}

class UserTable extends Doctrine_Table {
    public function findOneByLoginOrEmail( $login, $email ) {
        return Doctrine_Query::create()->from("User")
                       ->select("*")
                       ->addWhere("login = ?", $login)
                       ->addWhere("email = ?", $email)
                       ->limit(1)
                       ->fetchOne();
    }
}
