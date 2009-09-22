<?php
class Resource_Modify extends Record {

    const TYPE_AMOUNT_PERCENT = 1;
    const TYPE_AMOUNT_ACTUAL = 2;

    public function setTableDefinition() {
        $this->setTableName("resource_modifier");

        $this->hasIdColumn();
        $this->hasReferenceColumn("resource_id", TRUE);
        $this->hasReferenceColumn("subject_id", TRUE);
        $this->hasColumn("amount", "integer", array(
            "unsigned" => TRUE
        ) );
        $this->hasColumn("amount_type", "integer", array(
            "unsigned" => TRUE
        ) );
        $this->hasColumn("type", "integer");

        $this->hasSubclasses();
    }

    /**
     * @param int $amount
     * @return int
     */
    public function modify( $amount ) {
        switch ( $this->getAmountType() ) {
            case self::TYPE_AMOUNT_PERCENT:
                return $amount + $amount * ( $this->getAmount() / 100 );
            break;

            case self::TYPE_AMOUNT_ACTUAL:
                return $amount + $this->getAmount();
            break;
        }
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getAmountType() {
        return $this->amount_type;
    }

}

class Resource_ModifyTable extends Doctrine_Table {

    public function findBySubjectAndResource( Buildable_Object $subject, Resource $resource ) {
        return Doctrine_Query::create()->from("Resource_Modify")
                                       ->select("*")
                                       ->addWhere("subject_id = ?", $subject->getId() )
                                       ->addWhere("resource_id = ?", $resource->getId() )
                                       ->addWhere("subclass = ?", get_class( $subject ) )
                                       ->fetchOne();
    }

}