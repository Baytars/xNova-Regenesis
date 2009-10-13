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
		try {
			Session s = this.openSession();
			
			s.save(object);
			s.getTransaction().commit();
		} catch ( Throwable e ) {
			Main.error_log.error("", e);
		}
		return this;
	}
	
}
