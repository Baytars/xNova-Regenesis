package web.xnova.persistence.entities.planets;

import java.util.List;
import java.util.ArrayList;

import web.xnova.persistence.entities.buildables.*;
import web.xnova.persistence.entities.buildables.buildings.Building;
import web.xnova.persistence.entities.resources.*;
import web.xnova.persistence.entities.*;

public class Planet implements ResourceOwner {

	private Galaxy galaxy;
    private System system;
    private User owner;
    public List<PlanetQuadrant> quadrants;
    public List<ResourceAmount> resources;

    public System getSystem() {
    	return this.system;
    }

    public Planet setOwner( User owner ) {
    	this.owner = owner;
    	return this;
    }

    public List<Building> getBuildings() {
    	List<Building> result = new ArrayList<Building>();
    	
    	for( PlanetQuadrant q : this.quadrants ) {
    		result.add( q.getBuilding() );
    	}
    	
    	return result;
    }

	@Override
	public List<ResourceAmount> getResources() {
		return this.resources;
	}

}
