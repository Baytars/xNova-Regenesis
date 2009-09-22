<?php
/**
 * Stores requirements for all quest instances
 *
 * @author ilmar
 * @package Quest
 */
class Quest_Param extends Record{
    public function setTableDefinition(){
        $this->hasIdColumn();

        $this->setTableName("quest_params");
        $this->hasReferenceColumn("quest_id");
        $this->hasColumn("name", "string");
        $this->hasColumn("value", "float");
    }

    public function setUp(){
        $this->hasOne("Quest as quest", array(
                "local" => "quest_id",
                "foreign" => "id",
                "onDelete" => "CASCADE"
        ));
    }

    public function getName(){
        return $this->name;
    }

    public function getValue(){
        return $this->value;
    }

    public function setName($value){
        $this->name = $data;
        return $this;
    }

    public function setValue($value){
        $this->value = $data;
        return $this;
    }

}
?>
