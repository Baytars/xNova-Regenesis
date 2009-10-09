package web.xnova.persistence.managers;

import org.hibernate.Session;
import org.mvc.Main;
import org.mvc.persistence.Hibernate;

public class Manager<T> {
	
	protected Session getSession() throws Throwable {
		return Hibernate.getSessionFactory().getCurrentSession();
	}
	
	protected Session openSession() throws Throwable {
		Session s = this.getSession();
		if ( !s.getTransaction().isActive() ) {
			this.getSession().beginTransaction();
		}
		
		return s;
	}
	
	protected Manager<T> save( T object ) throws Throwable {
		Session s = this.openSession();
		
		s.save(object);
		s.getTransaction().commit();
		
		return this;
	}
	
}
