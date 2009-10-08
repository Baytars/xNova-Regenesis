package org.mvc.persistence;

import java.io.File;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;
import org.mvc.*;

public class Hibernate {
	
	private static SessionFactory sessionFactory;
	
	public static String hibernateCfgFile = Main.root_path.concat("/resources/hibernate.cfg.xml");
	
	private static SessionFactory buildSessionFactory() throws Throwable {
		return new Configuration().configure( new File( hibernateCfgFile ) )
								  		.buildSessionFactory()
								  		;
	}
	
	public static SessionFactory getSessionFactory() throws Throwable {
		if ( null == sessionFactory ) {
			sessionFactory = buildSessionFactory();
		}
		
		return sessionFactory;
	}
	
}
