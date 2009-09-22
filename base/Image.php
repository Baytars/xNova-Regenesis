<?php
class Image extends File {

    public function setTableDefinition() {
        $this->setTableName("images");

        parent::setTableDefinition();
        
        $this->hasColumn("type", "enum", array(
            "values" => array(
                IMAGETYPE_BMP,
                IMAGETYPE_JPEG,
                IMAGETYPE_GIF,
                IMAGETYPE_PNG,
                IMAGETYPE_WBMP
            )
        ));
    }

    public function getWebPath() {
        return Zend_Registry::get("config")->web->path->images . '/' . basename( $this->getPath() );
    }
    
}