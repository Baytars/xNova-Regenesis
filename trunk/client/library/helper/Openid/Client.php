<?php
require_once 'Auth/OpenID/Consumer.php';
require_once 'Auth/OpenID/SReg.php';

class Openid_Client {

    private $store_path;
    private $consumer;
    private $error;

    public function __construct() {
        $this->store_path = TMP_DIR.'/openid/client';
        if( !file_exists(TMP_DIR.'/openid')) {
            mkdir(TMP_DIR.'/openid');
        }
        if (!file_exists($this->store_path) &&
            !mkdir($this->store_path)) {
            throw Exception(_("Не удаётся создать хранилище временных файлов."));
        }

        $this->consumer = $this->getConsumer();
    }

    public function login($openid_identifier, $return_to, $trust_root, $ask_sreg = TRUE) {
        $auth_request = $this->consumer->begin($openid_identifier);

        if( !$auth_request ) {
            $this->setError(_('Неправильный OpenID'));
            return FALSE;
        }

        if( $ask_sreg ) {
            $sreg_request = Auth_OpenID_SRegRequest::build(
                                         // Required
                                         array(),
                                         // Optional
                                         array('nickname', 'fullname', 'email', 'dob', 'gender', 'language', 'country', 'timezone'));

            if ($sreg_request) {
                $auth_request->addExtension($sreg_request);
            }
        }

        // For OpenID 1, send a redirect.  For OpenID 2, use a Javascript
        // form to send a POST request to the server.
        if ($auth_request->shouldSendRedirect()) {
            $redirect_url = $auth_request->redirectURL($trust_root,
                                                       $return_to);

            // If the redirect URL can't be built, display an error
            // message.
            if (Auth_OpenID::isFailure($redirect_url)) {
                $this->setError(_('Не могу создать перенаправление') . " " . $redirect_url->message);
                return FALSE;
            } else {
                // Send redirect.
                header("Location: ".$redirect_url);
                exit;
            }
        } else {
            // Generate form markup and render it.
            $form_id = 'openid_message';
            $form_html = $auth_request->htmlMarkup($trust_root, $return_to,
                                                   false, array('id' => $form_id));

            // Display an error if the form markup couldn't be generated;
            // otherwise, render the HTML.
            if (Auth_OpenID::isFailure($form_html)) {
                $this->setError(_('Не могу создать перенаправление') . " " . $redirect_url->message);
                return FALSE;
            } else {
                print $form_html;
                print _('Идёт перенаправление…');
                exit;
            }
        }
    }

    public function check($params, $return_to, &$openid_identifier, &$sreg_fields = NULL) {
        $response = $this->consumer->complete($return_to);

        // Check the response status.
        if ($response->status == Auth_OpenID_CANCEL) {
            // This means the authentication was cancelled.
            $this->setError(_('Аутентификация отменена сервером'));
            return FALSE;
        } else if ($response->status == Auth_OpenID_FAILURE) {
            // Authentication failed; display the error message.
            $this->setError(_("Ошибка аутентификации") . " " . $response->message);
            return FALSE;
        } else if ($response->status == Auth_OpenID_SUCCESS) {
            // This means the authentication succeeded; extract the
            // identity URL and Simple Registration data (if it was
            // returned).
            $openid_identifier = $response->identity_url;

            $sreg_resp = @Auth_OpenID_SRegResponse::fromSuccessResponse($response);

            $sreg_fields = $sreg_resp->contents();

            return TRUE;
        }

        return FALSE;
    }

    public function getError() {
        return $this->error;
    }

    private function setError($error) {
        $this->error = $error;
    }

    private function getStore() {
        return new Auth_OpenID_FileStore($this->store_path);
    }

    private function getConsumer() {
        $store = $this->getStore();
        $consumer = new Auth_OpenID_Consumer($store, NULL, 'Openid_Client_Consumer');
        return $consumer;
    }
}

class Openid_Client_Fetcher extends Auth_Yadis_HTTPFetcher {

    function supportsSSL() {
        $v = curl_version();
        if(is_array($v)) {
            return in_array('https', $v['protocols']);
        } elseif (is_string($v)) {
            return preg_match('/OpenSSL/i', $v);
        } else {
            return 0;
        }
    }

    function get($url, $extra_headers = null) {
        $fetcher = Web_Fetcher::create();

        if( $extra_headers ) {
            if( is_array($extra_headers) ) {
                foreach($extra_headers as $header) {
                    $fetcher->addHeader($header);
                }
            } else {
                $fetcher->addHeader($extra_headers);
            }
        }

        $body = $fetcher->fetch($url);
        $headers = $fetcher->getHeaders();
        $code = $fetcher->getCode();
        $url = $fetcher->getUrl();
        return new Auth_Yadis_HTTPResponse($url, $code,
                                                    $headers, $body);
    }

    function post($url, $body, $extra_headers = NULL) {
        $fetcher = Web_Fetcher::create();

        if( $extra_headers ) {
            if( is_array($extra_headers) ) {
                foreach($extra_headers as $header) {
                    $fetcher->addHeader($header);
                }
            } else {
                $fetcher->addHeader($extra_headers);
            }
        }

        $params_strs = explode('&', $body);
        $params = array();
        foreach($params_strs as $param_str) {
            @list($key, $value) = explode('=', $param_str);
            if( $key && $value ) {
                $params[urldecode($key)] = urldecode($value);
            }
        }

        $body = $fetcher->fetch($url, $params, TRUE);
        $headers = $fetcher->getHeaders();
        $code = $fetcher->getCode();
        $url = $fetcher->getUrl();
        return new Auth_Yadis_HTTPResponse($url, $code,
                                                    $headers, $body);
    }
}

class Openid_Client_Consumer extends Auth_OpenID_GenericConsumer {

    public function __construct(&$store) {
        parent::Auth_OpenID_GenericConsumer($store);

        $this->fetcher = new Openid_Client_Fetcher();
    }

}