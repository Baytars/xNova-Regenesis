package web.xnova.persistence.entities;

import web.xnova.persistence.entities.planets.Planet;

import java.util.List;

public class User {

    private int id;
    private String lastname;
    private String name;
    private String login;
    private String email;
    private String password;
    private List<Planet> planets;

    public String getLogin() {
        return this.login;
    }

    public User setLogin(String login) {
        this.login = login;
        return this;
    }

    public String getName() {
    	return this.name;
    }
    
    public User setName( String name ) {
    	this.name = name;
    	return this;
    }
    
    public User setLastname( String lastname ) {
    	this.lastname = lastname;
    	return this;
    }
    
    public String getLastname() {
    	return this.lastname;
    }
    
    public String getPassword() {
        return this.password;
    }

    public User setPassword(String password) {
        this.password = password;
        return this;
    }

    public String getEmail() {
        return this.email;
    }

    public User setEmail(String email) {
        this.email = email;
        return this;
    }

    public int getId() {
        return this.id;
    }

    public User setId(int id) {
        this.id = id;
        return this;
    }

    public final List<Planet> getPlanets() {
        return this.planets;
    }

    public boolean checkPassword( String password ) {
    	return this.getPassword().equals( password );
    }

}
