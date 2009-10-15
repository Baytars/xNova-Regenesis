package web.xnova.persistence.entities.systems;

import java.util.List;
import web.xnova.persistence.entities.*;
import web.xnova.persistence.entities.planets.*;

abstract class System {

    private List<Planet> planets;
    private String name;
    private Galaxy galaxy;

    public System addPlanet( Planet planet) {
    	this.planets.add(planet);
    	return this;
    }

    public List<Planet> getPlanets() {
    	return this.planets;
    }


}
