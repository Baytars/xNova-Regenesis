<?php
/**
 * Surfaces of quadrants
 *
 * @author ilmar
 */
class Planet_Terrain extends Record {
    const TYPE_INACESSIBLE = 0;
    const TYPE_WALKABLE = 1;
    const TYPE_BUILDABLE = 2;
    
    public function setTableDefinition(){
        $this->setTableName("planet_terrains");

        $this->hasIdColumn();
        $this->hasReferenceColumn("quadrant_id", TRUE);
        $this->hasColumn("name", "string");
        $this->hasColumn("description", "string");
        //  path to image representing quadrant
        $this->hasColumn("texture", "string");
        //  ex. 0 - inaccesible, 1 - walkable, 2 - buildable
        $this->hasColumn("type", "int");
    }

    public function setType($new_type){
        $this->type = $new_type;
        return $this;
    }

    public function getType(){
        return $this->type;
    }

}