package org.mvc;

import java.io.IOException;

import org.mvc.reflection.*;
import org.apache.log4j.*;

public class Main {
	
	public static String root_path = "/home/nikelin/workspace/xnovaes-zend/trunk/java-web/";
	
	public static Logger log;
	public static Logger error_log;
	public static String defaultNotFoundPage = "/404";
	public static String defaultAccessDeniedPage = "/403";
	public static String defaultAuthRequiredPage = "/auth/login";
	
	private static ReflectionProvider _reflectionProvider;
	
	public static void start() {
		try {
			BasicConfigurator.configure();
			
			FileAppender defaultAppender = new FileAppender( new SimpleLayout(), Main.root_path.concat("/logs/main.log") );
			log = Logger.getRootLogger();
			log.setLevel( Level.ALL );
			log.addAppender(defaultAppender);
			
			FileAppender errorAppender = new FileAppender( new SimpleLayout(), Main.root_path.concat("/logs/errors.log") );
			error_log = Logger.getRootLogger();
			log.setLevel( Level.ERROR );
			log.addAppender( errorAppender );
		} catch ( IOException e ) {
			
		}
	}
	
	public static void setReflectionProvider( ReflectionProvider provider ) {
		_reflectionProvider = provider;
	}
	
	public static ReflectionProvider getReflectionProvider() {
		if ( null == _reflectionProvider) {
			_reflectionProvider = new BaseReflectionProvider();
		}
		
        return _reflectionProvider;
    }

}
