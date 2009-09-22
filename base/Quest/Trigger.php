<?php
/**
 * Checks if quest requirement or whole quest is completed
 *
 * @author ilmar
 * @package Quest
 */
abstract class Quest_Trigger {
	/**
	 * @var String
	 */
    protected $description_file;
	/**
	 * @var Quest
	 */
	private $quest;
	
	
	/**
	 * @param Quest $quest
	 * @return Quest_Trigger
	 */
	public function __construct( Quest $quest ) {
	    $this->quest = $quest;
	}
	
	/**
	 * Render quest description
	    $this->quest = $quest;
	}
	
	/**
	 * 
	 * @return string
	 */
    public function getDescription(){
    	if ( empty($this->description_file) ) {
    		throw new Exception("Not setted $description_file and not redeclared printMessage()");
    	}
    	
    	$view = new Zend_View();
    	return $view->render("quests/" . $this->description_file, $this );
    }
    
    /**
     * Check that user apply all requirements to handle this quest (level, etc.)
     * 
     * @param User $u
     * @return boolean
     */
    abstract public function canHandle(User $u);
    
    /**
     * Check that this quest is alredy completed by user
     * 
     * @return boolean
     */
    abstract public function isCompleted();

}
?>
