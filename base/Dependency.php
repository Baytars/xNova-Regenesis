<?php
/**
 * Model to represent dependencies between models, that user can develope (building, technology, etc.)
 *
 * @package models
 * @author nikelin
 */
class Dependency extends Record {

    const TYPE_BUILDING = 1;
    const TYPE_TECHNOLOGY = 2;

    public function setTableDefinition() {
        $this->setTableName("dependencies");

        $this->hasIdColumn();
        $this->hasReferenceColumn("subject_id", TRUE );
        $this->hasColumn("subject_class", "string");
        $this->hasColumn("level", "integer", array(
            "unsigned" => TRUE,
            "default" => 0
        ) );
        $this->hasReferenceColumn("object_id", TRUE );
        
        $this->hasSubclasses();
    }

    public function getObject() {
        return Doctrine::getTable( $this->subject_class )->find( $this->object_id );
    }

    public function getType() {
        return $this->type;
    }

    public function getLevel() {
        return $this->level;
    }

}

class DependencyTable extends Doctrine_Table {
    
}
