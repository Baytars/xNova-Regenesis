<?php
class AjaxRecaptcha extends Zend_Service_ReCaptcha {

    /**
     * Возвращает JSON-структуру данных необходимую для отображения
     * капчи на клиенте.
     *
     * @return String
     */
    public function getHtml() {
        if ($this->_publicKey === null) {
            /** @see Zend_Service_ReCaptcha_Exception */
            require_once 'Zend/Service/ReCaptcha/Exception.php';

            throw new Zend_Service_ReCaptcha_Exception('Missing public key');
        }

        $host = self::API_SERVER;
        if ($this->_params['ssl'] === true) {
            $host = self::API_SECURE_SERVER;
        }

        $info_array['pubkey'] = $this->_publicKey;
        $info_array['options'] = !empty($options) ? $options : array();
        $info_array['recaptcha_host'] = $host;


        return json_encode($info_array);
    }
}