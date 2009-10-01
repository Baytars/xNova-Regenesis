package web.xnova.entities;

import javax.persistence.*;

@Entity
public class Person {
	
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
