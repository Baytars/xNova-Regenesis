<?php
class Planet_Building extends Record implements Buildable_Interface {

    public function setTableDefinition() {
        $this->setTableName("planet_buildings");

        $this->hasIdColumn();
        $this->hasReferenceColumn("planet_id", TRUE);
        $this->hasReferenceColumn("building_id", TRUE);
        $this->hasReferenceColumn("quadrant_id", TRUE);
        $this->hasColumn("construction_starts", "integer", array(
            "notnull" => TRUE,
            "length" => LENGTH_UNIXTIMESTAMP
        ) );
        $this->hasColumn("level", "integer", array(
            "unsigned" => TRUE,
            "default" => 0
        ));
    }

    public function setUp() {
        $this->hasOne("Building as building", array(
            "local" => "building_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ));

        $this->hasOne("Planet_Quadrant as quadrant", array(
            "local" => "quadrant_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );
    }

    public function create( Planet $planet, Quadrant $quadrant, Building $building ) {
            return parent::create(array(
            "planet" => $planet,
            "quadrant" => $quadrant,
            "building" => $building
        ) );
    }

    public function getLevel() {
        return $this->level;
    }

    public function getName() {
        return $this->getBuilding()->getName();
    }

    public function getDescription() {
        return $this->getBuilding()->getDescription();
    }

    public function getDependencies() {
        return $this->building->getDependencies();
    }

    public function isReady() {
        return $this->level == 0 || $this->getRemainingTime() == 0;
    }

    public function getBuilding() {
        return $this->building;
    }

    public function getNeedsTime() {
        return $this->building->getConstructionTime();
    }

    public function getElapsedTime() {
        return time() - $this->construction_starts;
    }

    public function getRemainingTime() {
        if ( 0 > ( $remaining = $this->getNeedsTime() - $this->getElapsedTime() ) ) {
            return 0;
        } else {
            return $remaining;
        }
    }

    /**
     * Calculate amount of resource needs to stat building construction
     * using information about current building upgrade level.
     * 
     * @param int $base
     * @return int
     */
    public function getAffectedAmount( $base ) {
        return $base + $base * $this->getLevel() / 5;
    }

    /**
     * Calculate time to construct building using information about
     * building current building upgrade level.
     * 
     * @param int $base
     * @return int
     */
    public function getAffectedTime( $base ) {
        return ( $base + $base * $this->level );
    }

    /**
     * @return int
     */
    public function getConstructionTime() {
        return $this->getAffectedTime( $this->building->getConstructionTime() );
    }

    public function getAffectedValue( $value, Affectable $object ) {
        return $this->building->getAffectedValue( $value, $object );
    }

    public function getResourceAmounts() {
        $resource_amounts = $this->building->getResourceAmounts();

        $result = array();
        foreach( $resource_amounts as $resource_amount ) {
            $result [] = new Resource_Amount_Temp( $this->getAffectedAmount( $resource_amount->getAmount() ), $resource_amount->getResource() );
        }

        return $result;
    }

    public function increaseLevel() {
        $this->level += 1;
        $this->construction_starts = time();
        return $this;
    }

    public function decreaseLevel() {
        $this->level -= 1;
        $this->construction_starts = time();
        return $this;
    }

    public function getHoldingFields() {
        return $this->getAffectedAmount( $this->building->getHoldingFields() );
    }

    public function upgradeBuilding( Planet_Building $building ) {
        $building->increaseLevel()
                 ->save();

        return $this;
    }

    public function getStateParam() {
        return "building_construction";
    }

}

class Planet_BuildingTable extends Doctrine_Table {

    public function getByPlanetAndBuilding( Planet $planet, Building $building ) {
        $building = $this->findByPlanetAndBuilding( $planet, $building );
        if ( !$building ) {
            $building = new Planet_Building();
            $building->create( $planet, $building );
        }

        return $building;
    }

    public function findByPlanetAndBuilding( Planet $planet, Building $building ) {
        return Doctrine_Query::create()->from("Planet_Building")
                                       ->select("*")
                                       ->addWhere("planet_id = ?", $planet->getId() )
                                       ->addWhere("building_id = ?", $building->getId() )
                                       ->limit(1)
                                       ->fetchOne();
    }

}