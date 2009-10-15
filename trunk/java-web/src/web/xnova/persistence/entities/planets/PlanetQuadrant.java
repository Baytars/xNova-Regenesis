package web.xnova.persistence.entities.planets;

import java.util.List;

import web.xnova.persistence.entities.buildables.buildings.Building;
import web.xnova.persistence.entities.resources.*;

abstract class PlanetQuadrant implements ResourceOwner {

    private Building building;
    private List<QuadrantProperty> properties;
    private List<ResourceAmount> resources;

    /**
     * Method to check that this holder can handle
     * target building
     * 
     * @TODO Implement 
     * @param Construction building
     * @return
     */
    public boolean canHandle(Building building) {
    	return false;
    }
    
    @Override
    public List<ResourceAmount> getResources() {
    	return this.resources;
    }
    
    public Building getBuilding() {
    	return this.building;
    }
    
    /**
     * Set building state to "Deconstruction" which takes some
     * time after which current planet place will be empty
     * 
     * @TODO Implement 
     * @return
     */
    public PlanetQuadrant removeBuilding() {
    	//... Implement
    	
    	return this;
    }
    
    public PlanetQuadrant setBuilding( Building b ) {
    	this.building = b;
    	return this;
    }

}
