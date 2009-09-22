<?php
class Form_Auth_Login extends Form {
	
	public function __construct( array $options = array() ) {
		parent::__construct($options);
		
		$this->addElement("text", "login", array(
			"label" => _("Login"),
			"required" => TRUE,
			"decorators" => array(
				"viewHelper",
				array("errors", array( "tag" => "div", "placement" => "append" ) )
			)
		) );
		
		$this->addElement("password", "password", array(
			"label" => _("Password"),
			"required" => TRUE,
			"decorators" => array(
				"viewHelper",
				array("errors", array( "tag" => "div", "placement" => "append" ) )
			)
		) );
		
		if ( Zend_Form_Element_MetaCaptcha::enabled("login") ) {
			$this->addElement("metaCaptcha", "captcha");
		}
		
		$this->addElement("submit", "submit", array(
			"label" => "Sign In"
		));
	}
		
	// Main form login	
	public function mainProcess() {
		$adapter = new Zend_Auth_Adapter_LoginPassword( $this->getValue("login"), $this->getValue("password") );
		
		$result = Zend_Auth::getInstance()->authenticate( $adapter );
		
		if ( !$result->isValid() ) {
			$this->getElement("login")->addError("Wrong login or password");
			throw new Zend_Form_Exception;
		}
		
	}
}
