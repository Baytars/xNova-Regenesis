package web.xnova.entities;

import javax.persistence.*;

@Table(name="persons")
public class Person extends javax.persistence.Persistence {
	@Id
	private int id;
	
	@Column
	private String name;
	
	@Column
	private String lastname;
	
	@Column
	private String age;
	
	public Person( String name, String lastname ) {
		this.name = name;
		this.lastname = lastname;
	}
}
