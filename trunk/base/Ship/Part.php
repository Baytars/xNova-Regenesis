<?php 
class Ship_Part extends Buildable_Object {
	
	public function setTableDefinition() {
            parent::setTableDefinition();
            $this->setTableName("ship_parts");

            $this->hasReferenceColumn("ship_id", TRUE );
            $this->hasReferenceColumn("image_id", TRUE);

            $this->hasSubclasses();
	}
	
        public function setUp() {
            $this->hasMany("Resource_Amount as resource_amounts", array(
                "local" => "id",
                "foreign" => "subject_id"
            ) );

            $this->hasOne("Ship as ship", array(
                "local" => "ship_id",
                "foreign" => "id",
                "onDelete" => "CASCADE"
            ) );

            $this->hasMany("Ship_Modifier as modifiers", array(
                "local" => "id",
                "foreign" => "part_id"
            ) );
	}
	
	public function getModifier() {
		return $this->modifiers;
	}
	
}