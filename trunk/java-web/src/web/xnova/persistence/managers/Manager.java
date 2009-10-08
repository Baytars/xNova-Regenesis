package web.xnova.persistence.managers;

import org.hibernate.Session;
import org.mvc.Main;
import org.mvc.persistence.Hibernate;

public class Manager<T> {
	
	protected Session getSession() throws Throwable {
		return Hibernate.getSessionFactory().getCurrentSession();
	}
	
	protected Manager<T> save( T object ) throws Throwable {
		if ( !this.getSession().getTransaction().isActive() ) {
			this.getSession().beginTransaction();
		}
		
		this.getSession().save(object);
		this.getSession().getTransaction().commit();
		
		return this;
	}
	
}
