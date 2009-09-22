<?php 
class Modifier extends Record {
	const TYPE_ATTACK = 1;
	const TYPE_DEFENSE = 2;
	const TYPE_SPEED = 3;
	
	private static $subtypes = array(
	   self::TYPE_ATTACK => array(
	       "class" => "Modifier_Attack"
	   ),
	   self::TYPE_DEFENSE => array(
	       "class" => "Modifier_Defence"
	   )
	);
	
	public function setTableDefinition() {
		$this->setTableName("modifiers");
		
		$this->hasIdColumn();
		$this->hasColumn("type", "string", array(
		  "length" => LENGTH_NAME
		));
		$this->hasSubclasses();
	}
	
}