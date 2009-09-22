<?php
/**
 * Items on market
 *
 * @author ilmar
 */
class Market_Item extends Record{

    public function setTableDefinition(){
        $this->setTableName("market_item");

        $this->hasIdColumn();
        $this->hasReferenceColumn("subject_id", TRUE);
        $this->hasReferenceColumn("planet_id", TRUE);
        $this->hasColumn("subject_class", "string", array(
            "notnull" => TRUE
        ) );

        $this->hasColumn("count", "integer");
        $this->hasColumn("quant_price", "integer");
    }

    public function setUp(){
        $this->hasOne("Planet as planet", array(
            "local" => "planet_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );

    }

    public function getItemId(){
        return $this->item_id;
    }

    public function getPrice(){
        return $this->price;
    }

    public function getSellerId(){
        return $this->seller_id;
    }

    public function getStartDate(){
        return $this->start_date;
    }

    public function getEndDate(){
        return $this->expiration_date;
    }

}