<?php 
class AjaxController extends Zend_Controller_Action {
	
	public function init() {
		$this->_helper->getHelper("ContextSwitch")
		              ->addActionContext("get-ship-parts-by-type", "ajax")
		              ->initContext("json");
	}
	
	public function getShipPartsByTypeAction() {
		$type = intval( $this->_request->getParameter("type") );
		if ( empty($type) ) {
			throw new PageException_NotFound;
		}
		
		$parts = Doctrine::getTable("Ship_Part")->findBySubclass( $type );
		$this->view->parts = $parts->toArray(TRUE);
	}
	
}