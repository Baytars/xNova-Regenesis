<?php
/**
 * Каптча
 *
 * @bug не работает с именованными формами (проблема в том, что к именам полей, генерируемых reCAPTCHA, не добавляются префиксы)
 */
class Zend_Form_Element_MetaCaptcha extends Zend_Form_Element_Captcha {
    public function __construct($spec, $options = NULL) {
        if (!is_array($options)) {
            $options = array();
        }

        $ajax_mode = isset($options['mode']) && $options['mode'] == "ajax";

        $options["required"] = TRUE;
        $options["captcha"] = array(
            "captcha"   => "ReCaptcha",
            "privKey"   => Zend_Registry::get("config")->recaptcha->private,
            "pubKey"    => Zend_Registry::get("config")->recaptcha->public,
        );
        parent::__construct($spec, $options);

        if ( $ajax_mode ) {
            $this->getCaptcha()->setService( new AjaxRecaptcha($options['captcha']['pubKey'], $options['captcha']['privKey']) );
        }

        $this->getCaptcha()->getService()->setOptions(array(
            "lang"      => "ru",
            "theme"     => "clean",
            "create"    => true
        ));
    }

    /**
     * Включена ли каптча в данном месте?
     * @param string $token название места (например, "register"). "whole" — повсеместно.
     * @return bool
     */
    public static function enabled($token = "whole") {
        return Zend_Registry::get("config")->recaptcha->enabled && Zend_Registry::get("config")->recaptcha->enable->$token;
    }
}