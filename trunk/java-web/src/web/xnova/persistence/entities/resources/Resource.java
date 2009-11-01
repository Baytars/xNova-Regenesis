package web.xnova.persistence.entities.resources;

class Resource {

    private String name;

    public Resource setName(String name) {
        this.name = name;
        return this;
    }

    public String getName() {
        return this.name;
    }

}
