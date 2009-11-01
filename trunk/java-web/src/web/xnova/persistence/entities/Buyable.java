package web.xnova.persistence.entities;

import web.xnova.persistence.entities.resources.ResourceAmount;

import java.util.List;

public interface Buyable {

    public List<ResourceAmount> getCost();

}
