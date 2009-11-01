package web.xnova.persistence.entities.planets;

import web.xnova.persistence.entities.Galaxy;
import web.xnova.persistence.entities.User;
import web.xnova.persistence.entities.buildables.buildings.Building;
import web.xnova.persistence.entities.resources.ResourceAggregator;
import web.xnova.persistence.entities.resources.ResourceAmount;

import java.util.ArrayList;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

abstract public class Planet implements ResourceAggregator {

    private Galaxy galaxy;
    private System system;
    private User owner;
    public Set<PlanetQuadrant> quadrants = new HashSet<PlanetQuadrant>();
    public Set<ResourceAmount> resources = new HashSet<ResourceAmount>();

    public System getSystem() {
        return this.system;
    }

    public Planet setOwner(User owner) {
        this.owner = owner;
        return this;
    }

    public List<Building> getBuildings() {
        List<Building> result = new ArrayList<Building>();

        for (PlanetQuadrant q : this.quadrants) {
            result.add(q.getBuilding());
        }

        return result;
    }

    @Override
    public Set<ResourceAmount> getResources() {
        return this.resources;
    }

}
