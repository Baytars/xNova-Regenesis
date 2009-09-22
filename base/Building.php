<?php
/**
 * Model to represent some building, that user can construct.
 *
 * @package models
 * @author nikelin
 */
class Building extends Buildable_Object implements Resource_Proprietor, Affectable {

    public function setTableDefinition() {
        parent::setTableDefinition();

        $this->setTableName("buildings");
    }

    public function setUp() {
        parent::setUp();

        // Collection of resources amounts needs to construct building
        $this->hasMany("Resource_Amount as resource_amounts", array(
          "local" => "id",
          "foreign" => "subject_id"
        ) );

        // Collection of resources amounts what building generate for user (if it's do)
        $this->hasMany("Resource_Modify as resource_modifiers", array(
            "local" => "id",
            "foreign" => "subject_id"
        ));

        $this->hasMany("Dependency_Building as dependency_buildings", array(
            "local" => "id",
            "foreign" => "subject_id"
        ) );
    
        $this->hasMany("Dependency_Technology as dependency_technologies", array(
            "local" => "id",
            "foreign" => "subject_id"
        ) );
    }

    public function getResourceModifier( Resource $resource) {
        return Doctrine::getTable("Resource_Modify")->findBySubjectAndResource($this, $resource);
    }
}