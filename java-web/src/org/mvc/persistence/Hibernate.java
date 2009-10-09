package org.mvc.persistence;

import java.io.File;
import org.hibernate.SessionFactory;
import org.hibernate.cfg.Configuration;
import org.mvc.*;

import java.sql.*;
import java.util.Properties;

public class Hibernate {
	
	private static SessionFactory sessionFactory;
	
	public static String hibernateCfgFile = Main.root_path.concat("/src/webapp/WEB-INF/resources/hibernate.cfg.xml");
	
	private static SessionFactory buildSessionFactory() throws Throwable {
		DriverManager.registerDriver(new com.mysql.jdbc.Driver());
        
        Properties properties=new Properties();
        properties.setProperty("user","root");
        properties.setProperty("password","1");
        Connection conn = DriverManager.getConnection("jdbc:mysql://127.0.0.1/xnovae", properties);
		
        Statement statement = conn.createStatement();
        statement.execute("SHOW DATABASES");
        
        Main.log.trace( statement.getResultSet().isFirst() );
        
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
