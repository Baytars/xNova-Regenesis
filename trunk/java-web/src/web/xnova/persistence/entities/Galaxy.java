package web.xnova.persistence.entities;

import java.util.Set;
import java.util.HashSet;

public class Galaxy {

	private int id;
    private String name;
    private Set<System> systems = new java.util.HashSet<System>();

    public int getId() {
    	return this.id;
    }
    
    public Galaxy setId( int id ) {
    	this.id = id;
    	return this;
    }
    
    public Set<System> getSystems() {
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
