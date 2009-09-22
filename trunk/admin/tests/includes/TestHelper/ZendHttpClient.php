<?php
class TestHelper_ZendHttpClient implements Zend_Http_Client_Adapter_Interface {
    const LIFETIME = DAY;

    const STATUS_UNCACHABLE         = 1;
    const STATUS_CACHED             = 2;
    const STATUS_REAL_BEING_CACHED  = 3;

    protected $cache_file_name;

    protected $adapter_socket;
    protected $adapter_test;

    protected $status;

    protected $host;
    protected $port;
    protected $secure;

    public function __construct() {
        $this->adapter_socket = new Zend_Http_Client_Adapter_Socket();
        $this->adapter_test = new Zend_Http_Client_Adapter_Test();
    }

    /**
     * Set the configuration array for the adapter
     *
     * @param array $config
     */
    public function setConfig($config = array()) {
        $this->adapter_socket->setConfig($config);
        $this->adapter_test->setConfig($config);
    }

    /**
     * Connect to the remote server
     *
     * @param string  $host
     * @param int     $port
     * @param boolean $secure
     */
    public function connect($host, $port = 80, $secure = FALSE) {
        # реальное соединение будет происходить при первом обращении
        $this->host = $host;
        $this->port = $port;
        $this->secure = $secure;
    }

    /**
     * Send request to the remote server
     *
     * @param string        $method
     * @param Zend_Uri_Http $url
     * @param string        $http_ver
     * @param array         $headers
     * @param string        $body
     * @return string Request as text
     */
    public function write($method, $url, $http_ver = '1.1', $headers = array(), $body = '') {
        if ((Zend_Http_Client::GET == $method) || (Zend_Http_Client::HEAD == $method)) { // только эти методы можно кэшировать
            $this->cache_file_name = TEST_DATA . DIRECTORY_SEPARATOR . "http" . DIRECTORY_SEPARATOR . $this->host . DIRECTORY_SEPARATOR . sha1($url);
            if (
                file_exists($this->getCacheFileName())
                && (filemtime($this->getCacheFileName()) >= time() - self::LIFETIME)
                && (filesize($this->getCacheFileName()) > 0)
            ) {
                $this->status = self::STATUS_CACHED;
            } else {
                $this->status = self::STATUS_REAL_BEING_CACHED;
            }
        } else {
            $this->status = self::STATUS_UNCACHABLE;
        }
        $this->getAdapter()->connect($this->host, $this->port, $this->secure);
        return $this->getAdapter()->write($method, $url, $http_ver, $headers, $body);
    }

    /**
     * Read response from server
     *
     * @return string
     */
    public function read() {
        if (self::STATUS_CACHED == $this->getStatus()) {
            $this->getAdapter()->setResponse(file_get_contents($this->getCacheFileName()));
        }
        $response = $this->getAdapter()->read();
        if (self::STATUS_REAL_BEING_CACHED == $this->getStatus()) {
            $filename = $this->getCacheFileName();
            $directory = dirname($filename);
            if (!file_exists($directory)) {
                mkdir($directory);
            }
            file_put_contents($filename, $response);
        }
        return $response;
    }

    /**
     * Close the connection to the server
     *
     */
    public function close() {
        $this->getAdapter()->close();
    }

    protected function getStatus() {
        return $this->status;
    }

    protected function getAdapter() {
        return (self::STATUS_CACHED == $this->getStatus()) ? $this->adapter_test : $this->adapter_socket;
    }

    protected function getCacheFileName() {
        return $this->cache_file_name;
    }
}