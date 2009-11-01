package web.xnova.persistence.entities.planets;

import web.xnova.persistence.entities.buildables.buildings.Building;
import web.xnova.persistence.entities.resources.ResourceAggregator;
import web.xnova.persistence.entities.resources.ResourceAmount;

import java.util.List;
import java.util.Set;

abstract class PlanetQuadrant implements ResourceAggregator {

    private Building building;
    private List<QuadrantProperty> properties;
    private Set<ResourceAmount> resources;

    /**
     * Method to check that this holder can handle
     * target building
     *
     * @param Construction building
     * @return
     * @TODO Implement
     */
    public boolean canHandle(Building building) {
        return false;
    }

    @Override
    public Set<ResourceAmount> getResources() {
        return this.resources;
    }

    public Building getBuilding() {
        return this.building;
    }

    /**
     * Set building state to "Deconstruction" which takes some
     * time after which current planet place will be empty
     *
     * @return
     * @TODO Implement
     */
    public PlanetQuadrant removeBuilding() {
        //... Implement

        return this;
    }

    public PlanetQuadrant setBuilding(Building b) {
        this.building = b;
        return this;
    }

}
