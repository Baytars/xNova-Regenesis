<?php
/**
 * Main class for quests
 *
 * @author ilmar
 * @package Quest
 */
class Quest extends Record{
    
    /**
     * @var Quest_Trigger
     */
    private $trigger;
    
    public function setTableDefinition(){
        $this->setTableName("quests");

        $this->hasIdColumn();
        $this->hasReferenceColumn("user_id", TRUE);
        $this->hasColumn("name", "string", array(
            "length" => LENGTH_NAME,
            "notnull" => TRUE
        ));
        $this->hasColumn("trigger_type", "string", array(
            "notnull" => TRUE
        ));
        $this->hasColumn("create_time", "integer", array(
            "default" => 0
        ));
    }

    public function setUp(){
        $this->hasOne("User as user", array(
            "local" => "user_id",
            "foreign" => "id",
            "onDelete" => "CASCADE"
        ) );
        
        $this->hasMany("Quest_Param as params", array (
            "local" => "id",    
            "foreign" => "quest_id"
        ));
    }
    
    public function save() {
        if ( !$this->exists() ) {
            $this->create_time = time();
        }
        
        return parent::save();
    }
    
    /**
     * Check that user apply all requirements to handle this quest (level, etc.)
     * 
     * @param User $u
     * @return boolean
     */
    public function canHandle( User $u ) {
        return $this->getTrigger()->canHandle($u);
    }

    /**
     * Get user object for what this quest related
     * 
     * @return User
     */
    public function getUser(){
        return !empty($this->user_id) ? $this->user : null;
    }

    /**
     * Get quest description (scenario if you want)
     * 
     * @return Question_Trigger
     */
    public function getTrigger(){
        if ( !$this->trigger ) {
            if ( !class_exists( $this->trigger_type, TRUE ) ) {
                throw new Exception("Trigger class not found in include path");
            }
            
            $this->trigger = new $this->trigger_type($this);
        }
        
        return $this->trigger;
    }
    
    /**
     * Check that quest requirements is alredy completed
     * 
     * @return boolean
     */
    public function isCompleted() {
        return $this->getTrigger()->isCompleted();
    }
    
    /**
     * Get quest description
     * 
     * @return String
     */
    public function getDescription() {
        return $this->getTrigger()->getDescription();
    }

    /**
     * Get the parameter for current quest task
     * 
     * @param String $name
     * @return Quest_Param
     */
    public function getParam($name){
        return Doctrine::getTable("quest_param")->findOneByName($name);
    }

    /**
     * Set value of quest parameter
     * 
     * @param String $name
     * @param String $value
     * 
     * @return Quest
     */
    public function setParam($name, $value){
        $param = $this->getParam($name);
        if ( !$param ) {
            $param = new Quest_Param();
            $param->setName($name);
        }
        
        $param->setValue($value)
              ->save();
              
        return $this;
    }

}
?>
