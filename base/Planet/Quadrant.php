<?php
/**
 * Describes quadrant - thing that planet made of.
 *
 * @author ilmar
 */
class Planet_Quadrant extends Record {
    public function setTableDefinition(){
        $this->setTableName("planet_quadrants");

        $this->hasIdColumn();
        $this->hasReferenceColumn("planet_id",TRUE);
        // terrains, stored in /planet/terrain
        $this->hasReferenceColumn("terrain_id");
        // x and y coordinates of quadrant
        $this->hasColumn("row", "integer");
        $this->hasColumn("cell", "integer");
        
    }

    public function setUp(){
        $this->hasOne("Planet_Terrain as terrain", array(
            "local" => "terrain_id",
            "foreign" => "id",
            "onDelete" =>"SET NULL"
        ));
    }

    public function getX(){
        return $this->row;
    }

    public function getY(){
        return $this->column;
    }

}
