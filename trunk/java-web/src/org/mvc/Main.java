package org.mvc;

import java.io.IOException;

import org.mvc.reflection.*;
import org.apache.log4j.*;

public class Main {
	
	private static String currentLayout = "default";
	
	public static String root_path = "/home/nikelin/workspace/xnovaes-zend/trunk/java-web/";
	
	public static Logger log;
	public static Logger error_log;
	public static String defaultNotFoundPage = "/jsp/404.jsp";
	public static String defaultAccessDeniedPage = "/jsp/403.jsp";
	public static String defaultAuthRequiredPage = "/auth/login";
	public static String defaultErrorPage = "/jsp/501.jsp";
	
	private static ReflectionProvider _reflectionProvider;
	
	public static String getCurrentLayout() {
		return currentLayout;
	}
	
	public static void setCurrentLayout( String layout ) {
		currentLayout = layout;
	}
	
	public static void start() {
		try {
			BasicConfigurator.configure();
			
			FileAppender defaultAppender = new FileAppender( new SimpleLayout(), Main.root_path.concat("/logs/main.log") );
			defaultAppender.setAppend(false);
			log = Logger.getRootLogger();
			log.setLevel( Level.ALL );
			log.addAppender(defaultAppender);
			
			FileAppender errorAppender = new FileAppender( new SimpleLayout(), Main.root_path.concat("/logs/errors.log") );
			errorAppender.setAppend(false);
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
