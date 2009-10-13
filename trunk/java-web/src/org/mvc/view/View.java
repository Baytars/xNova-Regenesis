package org.mvc.view;

import java.io.IOException;
import java.io.File;
import java.io.FileReader;
import java.util.HashMap;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

import org.mvc.Main;

public class View {
	public static String defaultEncoding = "UTF-8";
	public static String defaultContentType = "text/html";	

	private HashMap<String, Object> parameters;
	
	public View() {
		this.parameters = new HashMap<String, Object>();
	} 

	public void setParameter( String name, Object value ) {
		this.parameters.put(name, value);
	}
	
	public Object getParameter( String name ) {
		return this.parameters.containsKey(name) ? this.parameters.get(name) : null;
	}
	
	public HashMap<String, Object> getParameters() {
		return this.parameters;
	}


	
}