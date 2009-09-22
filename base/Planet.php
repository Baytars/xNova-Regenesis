<?php
class Planet extends Record implements Resource_Proprietor {

    public function setTableDefinition() {
        $this->setTableName("planets");

        $this->hasIdColumn();
        $this->hasReferenceColumn("profile_id", TRUE);
        $this->hasReferenceColumn("system_id", TRUE);
        // planet dimensions, in quadrants
        $this->hasColumn("width", "int");
        $this->hasColumn("height", "int");
        
        $this->hasColumn("fields_usage", "integer", array(
            "unsigned" => TRUE,
            "default" => 0
        ) );
        
        $this->hasColumn("name", "string", array(
            "length" => LENGTH_NAME,
            "notnull" => TRUE
        ) );
    }

    public function setUp() {
        $this->hasOne("System as system", array(
            "local" => "system_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );

        $this->hasOne("Planet_Profile as profile", array(
            "local" => "profile_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );

        $this->hasMany("Planet_Building as buildings", array(
            "local" => "id",
            "foreign" => "planet_id"
        ) );

        $this->hasMany("Ship as ships", array(
            "local" => "id",
            "foreign" => "planet_id"
        ) );

        $this->hasMany("Resource_Amount as resources", array(
            "local" => "id",
            "foreign" => "subject_id"
        ) );

        $this->hasMany("Planet_Quadrant as quadrants", array(
            "local" => "id",
            "foreign" => "planet_id"
        ) );
    }

    public function create( $name, System $system, Planet_Profile $profile ) {
        return parent::create(array(
            "name" => $name,
            "system" => $system,
            "profile" => $profile
        ) );
    }

    /**
     * Create new building in this planet
     * 
     * @param Planet $planet
     * @param Building $building
     * 
     * @return Planet_Building
     */
    public static function createBuilding( Planet $planet, Quadrant $quadrant, Building $building ) {
        $planet_building = new Planet_Building();
        $planet_building->create( $planet, $quadrant, $building );

        return $planet_building;
    }

    /**
     * Return count of free fields for buildings construction
     * on planet
     *
     * @return int
     */
    public function getLeftFields() {
        return $this->fields_usage - $this->getProfile()->getFieldsCount();
    }

    public function getUser() {
        return $this->getSystem()->getUser();
    }

    public function getProfile() {
        return $this->profile;
    }

    public function getSystem() {
        return $this->system;
    }

    public function getBuildings() {
        return $this->buildings;
    }

    public function getName() {
        return $this->name;
    }
    
    public function canBuild( Buildable_Interface $object ) {
        if ( !$this->hasDependencies( $object ) ) {
            return FALSE;
        }

        if ( $object->getHoldingFields() > $this->getLeftFields() ) {
            return FALSE;
        }

        foreach( $this->getBuildings() as $building ) {
            if ( !$building->isReady() ) {
                return false;
            }
        }
        
        return $this->canProvideResources( $object->getResourceAmounts() );
    }

    /**
     * Check that user has all objects that subject needs to be builded up
     *
     * @param Buildable $subject
     * @return bool
     */
    public function hasDependencies( Buildable_Interface $subject ) {
        foreach( $subject->getDependencies() as $dependency ) {
            if ( !$this->hasDependency($dependency) ) {
                return FALSE;
            }
        }

        return TRUE;
    }

    public function hasDependency( Dependency $dependency ) {
        switch ( $dependency->getType() ) {
            case Dependency::TYPE_BUILDING:
                if ( !$this->hasBuilding( $dependency->getObject(), $dependency->getLevel() ) ) {
                    return FALSE;
                }
            break;
            
            case Dependency::TYPE_TECHNOLOGY:
                if ( !$this->hasTechnology( $dependency->getObject(), $dependency->getLevel() ) ) {
                    return FALSE;
                }
            break;
        }

        return TRUE;
    }

    public function hasBuilding( Building $building, $level = NULL ) {
        $user_building = $this->getBuilding($building);

        if ( !$user_building ) {
            return FALSE;
        }

        if ( $level != NULL ) {
            return $user_building->getLevel() >= $level;
        }

        return TRUE;
    }

    public function getShips() {
        return $this->ships;
    }

    public function getBuilding( Building $building, $create = FALSE ) {
        if ( $create ) {
            return self::createBuilding( $this, $building );
        } else {
            return Doctrine::getTable("Planet_Building")->findByPlanetAndBuilding( $this, $building );
        }
    }

    public function addBuilding( Building $building ) {
        $building = $this->getBuilding( $building, TRUE );

        $building->increaseLevel()
                 ->save();

        $this->fields_usage += $building->getHoldingFields();
        
        return $this;
    }

    public function upgradeBuilding( Building $building ) {
       $this->getBuilding($building)
            ->increaseLevel()
            ->save();

       return $this;
    }

    public function setName( $value ) {
        $this->name = $value;
        return $this;
    }

    public function getCoords() {
        return array(
            "galaxy" => $this->getSystem()->getGalaxy()->getId(),
            "system" => $this->getSystem()->getId(),
            "planet" => $this->getId()
        );
    }

    public function getResourceAmounts() {
        return $this->resources;
    }

    public function getResourceAmount( Resource $resource ) {
        $amount = Doctrine::getTable("Resource_Amount")->findBySubjectAndResource( $this, $resource );

        return $amount ? $amount->getAmount() : 0;
    }

    public function canProvideResource( $amount, Resource $resource ) {
        return $this->getResourceAmount( $resource ) >= $amount;
    }

    public function useResource( $amount, Resource $resource ) {
        $resource_amount = $this->getResourceAmount($resource);

        if ( $this->canProvideResource( $amount, $resource ) ) {
            $resource_amount->decrease( $amount )
                     ->save();
        }

        return $this;
    }

    public function canProvideResources($collection) {
        foreach( $collection as $resource_amount ) {
            if ( !$this->canProvideResource( $resource_amount->getAmount(), $resource_amount->getResource() ) ) {
                return FALSE;
            }
        }

        return TRUE;
    }

    public function getAffectedValue( $base, Affectable $resource ) {
        switch ( $resource->getType() ) {
            case Affectable::TYPE_RESOURCE:
                $base = ( $base + 1 ) * Zend_Registry::get("config")->coefficients->resources->increase;
            break;
        }

        foreach ( $planet->getBuildings() as $building ) {
            if ( $building->isReady() ) {
                $base += $building->getAffectedValue( $base, $resource );
            }
        }

        return $base;
    }

    public function updateResources() {
        /**
         * @TODO needs to calculate affect of constructed buildings for increasing of user resources
         */
         foreach( $this->getResourceAmounts() as $resource_amount ) {
             $resource_amount->increase( $this->getAffectedValue( $resource_amount->getAmount(), $resource_amount->getResource() ) )
                             ->save();
         }

         return $this;
    }
}