<?php
class Zend_Cache_Frontend_Outputx extends Zend_Cache_Frontend_Output {
    protected function isDisabled() {
        return Zend_Registry::get("config")->server->development;
    }

    public function start($id, $doNotTestCacheValidity = FALSE, $echoData = TRUE) {
        return $this->isDisabled() ? FALSE : parent::start($id, $doNotTestCacheValidity, $echoData);
    }

    public function end($tags = array(), $specificLifetime = FALSE, $forcedDatas = NULL, $echoData = TRUE, $priority = 8) {
        return $this->isDisabled() ? NULL : parent::end($tags, $specificLifetime, $forcedDatas, $echoData, $priority);
    }
}