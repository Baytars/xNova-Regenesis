package com;

import java.util.Map;

public class Registry {
	Map<String, Object> dict;
	private static Registry _instance;
	
	public static Object set( String name, Object value ) {
		instance().dict.put(name, value);
		
		return value;
	}
	
	public static Object get( String name ) {
		return instance().dict.get(name);
	}
	
	public static Registry instance() {
		if ( _instance == null ) {
			_instance = new Registry();
		}
		
		return _instance;
	}
}
