<?php
/**
 * Entity to represent items price using resource amount
 *
 * @package models
 * @author nikelin
 */
class Resource_Amount extends Record {

    public function setTableDefinition() {
        $this->setTableName("resources_amount");
        
        $this->hasIdColumn();
        $this->hasReferenceColumn("resource_id", TRUE); 
        $this->hasReferenceColumn("subject_id", TRUE);
        $this->hasReferenceColumn("amount", TRUE);
        $this->hasReferenceColumn("type", TRUE);

        $this->hasSubclasses();
    }

    public function setUp() {
        $this->hasOne("Resource as resource", array(
            "local" => "resource_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );
    }

    public function getResource() {
        return $this->resource;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function decrease( $amount ) {
        if ( $amount < 0 ) {
            throw new Exception("decrease amount must be greater than 0");
        }

        $this->amount -= $amount;
        return $this;
    }

    public function increase( $amount ) {
        if ( $amount < 0 ) {
            throw new Exception("increase amount must be greater than 0");
        }

        $this->amount += $amount;
        return $this;
    }

}

class Resource_AmountTable extends Doctrine_Table {

    public function findBySubjectAndResource( Resource_Proprietor $subject, Resource $resource ) {
        return Doctrine_Query::create()->from("Resource_Amount")
                                       ->select("*")
                                       ->addWhere("subclass = ?", get_class( $subject ) )
                                       ->addWhere("subject_id = ?", $subject->getId() )
                                       ->addWhere("resource_id = ?", $resource->getId() )
                                       ->limit(1)
                                       ->fetchOne();
    }
}