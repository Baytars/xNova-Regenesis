<?php
class Technology extends Buildable_Object {

    public function setTableDefinition() {
        parent::setTableDefinition();
        
        $this->setTableName("technologies");
    }

    public function setUp() {
        parent::setUp();
        
    }

    public function getResourceModifier( Resource $resource) {
        return Doctrine::getTable("Resource_Modify")->findBySubjectAndResource($this, $resource);
    }

    
}