package org.uinator.utils;

import java.util.HashMap;

/**
 *
 * @author nikelin
 */
public class Registry {

    private static Registry _instance;
    private HashMap<String, Object> _dict;

    private Registry() {
        this._dict = new HashMap<String, Object>();
    }

    protected static Registry instance() {
        if ( _instance == null ) {
            _instance = new Registry();
        }

        return _instance;
    }

    public static Object get( String name ) {
        return instance()._dict.get(name);
    }

    public static void set( String name, Object value ) {
        instance()._dict.put(name, value);
    }
}

class Registry_NotFoundException extends Exception {

	/**
	 * 
	 */
	private static final long serialVersionUID = -7747529005497091717L;}
