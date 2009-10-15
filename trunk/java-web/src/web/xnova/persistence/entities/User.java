package web.xnova.persistence.entities;

import java.util.List;
import web.xnova.persistence.entities.planets.*;

public class User {

	private int id;
	private String login;
	private String email;
	private String password;
    private List<Planet> planets;

    public String getLogin() {
    	return this.login;
    }
    
    public User setLogin( String login ) {
    	this.login = login;
    	return this;
    }
    
    public String getPassword() {
    	return this.password;
    }
    
    public User setPassword( String password ) {
    	this.password = password;
    	return this;
    }
    
    public String getEmail() {
    	return this.email;
    }
    
    public User setEmail( String email ) {
    	this.email = email;
    	return this;
    }
    
    public int getId() {
    	return this.id;
    }
    
    public User setId( int id ) {
    	this.id = id;
    	return this;
    }
    
    public final List<Planet> getPlanets() {
    	return this.planets;
    }


}
