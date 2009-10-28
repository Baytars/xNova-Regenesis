package web.xnova.persistence.managers;

import org.hibernate.Session;
import org.mvc.Main;
import org.mvc.persistence.Hibernate;

public class Manager {
	
	protected Session getSession() throws Throwable {
		return Hibernate.getSessionFactory().getCurrentSession();
	}
	
	public Session openSession() throws Throwable {
		Session s = this.getSession();
		if ( !s.getTransaction().isActive() ) {
			this.getSession().beginTransaction();
		}
		
		return s;
	}
	
	public Manager update( Object object) throws Throwable {
		this.openSession();
		this.getSession().update(object);
		return this;
	}
	
	public Manager save( Object object ) throws Throwable {
		try {
			Session s = this.openSession();
			
			s.save(object);
			s.getTransaction().commit();
		} catch ( Throwable e ) {
			throw e;
		}
		return this;
	}
	
}
