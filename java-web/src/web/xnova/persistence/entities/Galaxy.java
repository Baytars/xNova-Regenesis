package web.xnova.persistence.entities;

import java.util.List;

public class Galaxy {

    private String name;
    private List<System> systems;

    public List<System> getSystems() {
    	return this.systems;
    }

    public Galaxy addSystem( System system) {
    	this.systems.add( system );
    	return this;
    }
    
    public Galaxy setName( String name ) {
    	this.name = name;
    	return this;
    }
    
    public String getName() {
    	return this.name;
    }


}
