<?php
/**
 * @author nikelin
 * @package models
 * @abstract
 */
abstract class Buildable_Object extends Record implements Buildable_Interface {

    public function setTableDefinition() {
        $this->hasIdColumn();
        $this->hasReferenceColumn("image_id");
        
        $this->hasColumn("name", "string", array(
            "notnull" => TRUE,
            "length" => LENGTH_NAME
        ) );

        $this->hasColumn("description", "string", array(
            "notnull" => TRUE,
            "length" => LENGTH_DESCRIPTION
        ) );

        $this->hasColumn("construction_time", "integer", array(
            "notnull" => TRUE,
            "length" => LENGTH_UNIXTIMESTAMP
        ) );

        $this->hasColumn("holding_fields", "integer", array(
            "unsigned" => TRUE,
            "default" => 0
        ) );
    }

    public function setUp() {
        $this->hasOne("Image as image", array(
            "local" => "image_id",
            "foreign" => "id",
            "onDelete" => "SET NULL"
        ) );
    }

    /**
     * Return collection of Resource_Amount objects which describe
     * building construction price.
     *
     * @return Doctrine_Collection<Resource_Amount>
     */
    public function getResourceAmounts() {
        return $this->resource_amounts;
    }

    /**
     * Increase level of building
     *
     * @return Buildable
     * @abstract
     */
    public function increaseLevel() {
        $this->level += 1;
        return $this;
    }

    /**
     * Decrease level of building
     *
     * @return Buildable
     * @abstract
     */
     public function decreaseLevel() {
         $this->level -= 1;
         return $this;
     }

    /**
     * Return fields on planet needs to place construction
     *
     * @return int
     */
    public function getHoldingFields() {
        return $this->holding_fields;
    }

    public function getMaxLevel() {
        return $this->max_level;
    }

    public function modifyResourceAmount($amount, Resource $object) {
        $modifier = $this->getResourceModifier($object);

        if ( $modifier == FALSE ) {
            return $amount;
        }

        return $modifier->modify($amount);
    }

    public function getAffectedValue( $value, Affectable $object ) {
        switch( $object->getType() ) {
            case Affectable::TYPE_RESOURCE:
                return $this->modifyResourceAmount($value, $object);
            break;
        }

        return $value;
    }

    public function getResourceModifier( Resource $resource ) {
        return FALSE;
    }

    public function getDependencies() {
        $collection = new Doctrine_Collection("Dependency");
        $collection->merge( $this->dependency_buildings );
        $collection->merge( $this->dependency_technologies );

        return $collection;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getConstructionTime() {
        return $this->construction_time;
    }

    public function getLevel() {
        return 0;
    }

    public function isReady() {
        return true;
    }
   
}