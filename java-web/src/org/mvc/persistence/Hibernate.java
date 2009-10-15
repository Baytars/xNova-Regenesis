package org.mvc.persistence;

import java.io.File;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;
import org.mvc.*;
import java.sql.*;

public class Hibernate {
	
	private static SessionFactory sessionFactory;
	
	public static String hibernateCfgFile = Main.root_path.concat("/src/webapp/WEB-INF/resources/hibernate.cfg.xml");
	
	private static SessionFactory buildSessionFactory() throws Throwable {
		DriverManager.registerDriver( new org.gjt.mm.mysql.Driver() );
		
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
