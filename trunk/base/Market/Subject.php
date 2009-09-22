<?php
class Market_Subject extends Record {

    public function setTableDefinition() {
        $this->setTableName("market_subjects");

        $this->hasReferenceColumn("item_id", TRUE);
        $this->hasReferenceColumn("subject_id", TRUE);
        $this->hasReferenceColumn("subject_class", TRUE );
    }

    public function setUp() {
        $this->hasOne("Market_Item as item", array(
            "local" => "item_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );
    }

}
