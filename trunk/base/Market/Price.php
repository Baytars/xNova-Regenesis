<?php
/**
 * Prices of items in the market. Stored as pairs of name - value, where name == id of the resource
 * and value == quantity of that resource.
 *
 * @author ilmar
 */
class Market_Price extends Record{
    public function setTableDefinition(){
        $this->setTableName("market_price");

        $this->hasIdColumn();
        $this->hasColumn("name", "string");
        $this->hasColumn("value", "int");
    }

    public function setUp(){
        $this->hasOne("Market_Item as item", array(
                "local" => "id",
                "foreign" => "price_id"));
    }
}
?>
