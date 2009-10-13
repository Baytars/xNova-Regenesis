package web.xnova.persistence.entities;

public class User {
	
	private int id;
	private String login;
	private String password;
	private String email;
	
	public User setId( int id ) {
		this.id = id;
		return this;
	}
	
	public int getId() {
		return this.id;
	}
	
	public User setLogin( String login ) {
		this.login = login;
		return this;
	}
	
	public User setPassword( String password ) {
		this.password = password;
		return this;
	}
	
	public String getPassword() {
		return this.password;
	}
	
	public User setEmail( String email ) {
		this.email = email;
		return this;
	}
	
	public String getEmail() {
		return this.email;
	}
	
	public String getLogin() {
		return this.login;
	}
	
	/**
	 * @todo Needs password hashing
	 * @param password
	 * @return boolean
	 */
	public boolean checkPassword( String password ) {
		return this.password.equals(password);
	}
	
	
	
}
