<?php
class Ship_Modifier extends Record {
	const TYPE_DAMAGE = 1;
	const TYPE_DEFENCE = 2;
	
	public function setTableDefinition() {
		$this->setTableName("ship_modifier");
		
		$this->hasIdColumn();
		$this->hasReferenceColumn("part_id", TRUE);
		$this->hasColumn("value", "integer");
		$this->hasSubclasses();
	}
	
	public function setUp() {
		$this->hasOne("Ship_Part as part", array(
		  "local" => "part_id",
		  "foreign" => "id",
		  "onDelete" => "CASCADE"
		) );
	}
	
}