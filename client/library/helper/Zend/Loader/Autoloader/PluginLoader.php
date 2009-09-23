<?php
class Zend_Loader_Autoloader_PluginLoader extends Zend_Loader_PluginLoader implements Zend_Loader_Autoloader_Interface {
    public function autoload($class) {
        foreach ($this->getPaths() as $namespace => $paths) {
            if (0 === strpos($class, $namespace)) { // if $class belongs to $namespace
                $result = $this->load(substr($class, strlen($namespace)), FALSE);
                return !empty($result);
            }
        }
        return FALSE;
    }
}