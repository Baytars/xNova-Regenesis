package web.xnova.persistence.entities.resources;

import web.xnova.persistence.entities.Buyable;

public class ResourceAmount {

    private Resource resource;
    private int amount;
    private Buyable subject;

    public Buyable getSubject() {
        return this.subject;
    }

    public int getAmount() {
        return this.amount;
    }

    public Resource getResource() {
        return this.resource;
    }

}
