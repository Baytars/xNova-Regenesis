<?php
class Form_Auth_Register extends Form {
	
    public function __construct( array $options = array() ) {
        parent::__construct( $options );

        $this->addElement("text", "login", array(
            "label" => "Your login",
            "required" => TRUE,
            "decorators" => array(
                    "viewHelper",
                    array("errors", array("tag" => "div", "placement" => "append") )
            )
        ) );

        $this->addElement("text", "email", array(
            "label" => "Your email",
            "required" => TRUE,
            "validators" => array(
                "EmailAddress"
            ),
            "decorators" => array(
                "viewHelper",
                array("errors", array("tag" => "div", "placement" => "append") )
            )
        ) );

        if ( Zend_Form_Element_MetaCaptcha::enabled("register") ) {
            $this->addElement("metaCaptcha", "captcha");
        }

        $this->addElement("password", "password", array(
            "label" => "Password",
            "required" => TRUE,
            "decorators" => array(
                "viewHelper",
                array("errors", array("tag" => "div", "placement" => "append") )
            )
        ) );

        $this->addElement("password", "password_retype", array(
            "label" => "Re-type password",
            "required" => TRUE,
            "validators" => array(
                    new Zend_Validate_RepeatPassword("password")
            ),
            "decorators" => array(
                "viewHelper",
                array("errors", array("tag" => "div", "placement" => "append") )
            )
        ) );

        $this->addElement( $this->getGalaxiesList() );

        $this->addElement("text", "empire_name", array(
            "label" => "Planet name",
            "required" => TRUE,
            "decorators" => array(
                "viewHelper",
                array( "errors", array( "tag" => "div", "placement" => "append") )
            )
        ) );

        $this->addElement("submit", "submit", array(
            "label" => "Sign Up"
        ) );
    }

    protected function mainProcess() {
        $user = Doctrine::getTable("User")->findOneByLoginOrEmail( $this->getValue("login"), $this->getValue("email") );
        if ( $user !== FALSE ) {
                if ( $user->getLogin() == $this->getValue("login") ) {
                    $this->getElement("login")->addError("is not available");
                }

                if ( $user->getEmail() == $this->getValue("email") ) {
                    $this->getElement("email")->addError("is not available");
                }

                throw new Zend_Form_Exception;
        }
        
        $galaxy = Doctrine::getTable("Galaxy")->find( intval( $this->getValue("galaxies") ) );
        if ( !$galaxy ) {
            $this->getElement("galaxies")->addError( _("selected galaxy does not exists") );
        }

        $user = new User();
        $user->create(
                $this->getValue("login"),
                $this->getValue("email"),
                $this->getValue("password"),
                $this->getValue("empire_name"),
                $this->getGalaxy()
        );

        $adapter = new Zend_Auth_Adapter_LoginPassword( $this->getValue("login"), $this->getValue("password") );
        $result = Zend_Auth::getInstance()->authenticate( $adapter );
    }

    protected function getGalaxy() {
        return Doctrine::getTable("Galaxy")->find( $this->getValue("galaxies") );
    }

    protected function getGalaxiesList() {
        $list = new Zend_Form_Element_Select("galaxies");
        foreach ( Doctrine::getTable("Galaxy")->findAll() as $galaxy ) {
            $list->addMultiOption( $galaxy->getId(), $galaxy->getName() );
        }

        $list->setDecorators(array(
            "viewHelper",
            array( "errors", array( "tag" => "div", "placement" => "append" ) )
        ));

        return $list;
    }
}
