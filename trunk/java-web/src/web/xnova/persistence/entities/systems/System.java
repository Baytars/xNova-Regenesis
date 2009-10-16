package web.xnova.persistence.entities.systems;

import java.util.Set;
import java.util.HashSet;

import web.xnova.persistence.entities.*;
import web.xnova.persistence.entities.planets.*;

abstract public class System {

	private int id;
    private Set<Planet> planets = new HashSet<Planet>();
    private String name;
    private Galaxy galaxy;
    
    public System setName( String name ) {
    	this.name = name;
    	return this;
    }
    
    public String getName() {
    	return this.name;
    }
    
    public System setGalaxy( Galaxy g ) {
    	this.galaxy = g;
    	return this;
    }
    
    public Galaxy getGalaxy() {
    	return this.galaxy;
    }
    
    public System addPlanet( Planet planet) {
    	this.planets.add(planet);
    	return this;
    }

    public Set<Planet> getPlanets() {
    	return this.planets;
    }


}
