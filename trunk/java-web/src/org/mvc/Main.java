package org.mvc;

import java.io.File;

import org.mvc.reflection.*;
import org.mvc.utils.*;
import org.mvc.io.adapter.*;

public class Main {
	
	public static String root_path = "/home/nikelin/workspace/xnovaes-zend/trunk/java-web/";
	
	public static Log log;
	public static Log error_log;
	public static String defaultNotFoundPage = "/404";
	public static String defaultAccessDeniedPage = "/403";
	public static String defaultAuthRequiredPage = "/auth/login";
	
	private static ReflectionProvider _reflectionProvider;
	
	public static void start() {
		try {
			log = new Log();
			log.setAdapter( new FileAdapter( Main.root_path.concat("/logs/main.log") ) );
			
			error_log = new Log();
			error_log.setAdapter( new FileAdapter( Main.root_path.concat("/logs/error.log") ) );
		} catch ( Exception e ) {
			throw new Error(e);
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
