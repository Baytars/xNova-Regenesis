package org.mvc.http;

import org.mvc.controller.*;
import org.mvc.*;

import javax.servlet.http.HttpServletRequest;

import java.util.HashMap;
import java.util.Enumeration;

public class HttpRequest {
	private String controllerName;
	private String actionName;
	private HashMap<String, String> params;
	private HttpServletRequest original_request;
	
	private static final int TOKEN_CONTROLLER_NAME = 1;
	private static final int TOKEN_ACTION_NAME = 2;
	private static final int TOKEN_PARAM_NAME = 3;
	private static final int TOKEN_PARAM_VALUE = 4;
	
	public HttpRequest() {
		this.controllerName = new String();
		this.actionName = new String();
		this.params = new HashMap<String, String>();
	}
	
	public HttpRequest( HttpServletRequest request ) {
		this();
		
		this.original_request = request;
		
		this.processUri();
		this.processParams();
	}
	
	public HttpServletRequest getOriginalRequest() {
		return this.original_request;
	}
	

	protected void processParams() {
		Enumeration<String> names = (Enumeration<String>) this.original_request.getParameterNames();
		if ( !names.hasMoreElements() ) {
			return;
		}
		
		for( String name = names.nextElement(); names.hasMoreElements(); name = names.nextElement() ) {
			if ( this.params.containsKey( name ) ){
				continue;
			} else {
				this.params.put( name, this.original_request.getParameter(name) );
			}
		}
	}
	
	protected void processUri() {
		String uri = this.original_request.getRequestURI().replace(".jsp", "");
		if ( uri.startsWith("/") ) {
			uri = uri.substring(1);
		}
		
		
		// for temprorary value to represent current request param name 
		// when processing params part
		String paramName = new String();
		String paramValue = new String();

		int pos = 0;
		int context = 0;
		while ( pos < uri.length() ) {
			char currChar = uri.charAt(pos);
			
			switch ( context ) {
			case TOKEN_CONTROLLER_NAME:
				if ( currChar == '/' ) {
					context = TOKEN_ACTION_NAME;
				} else {
					this.controllerName = this.controllerName.concat( String.valueOf( currChar ) );
				}
			break;
			case TOKEN_ACTION_NAME:
				if ( currChar == '/' || currChar == '?' ) {
					context = TOKEN_PARAM_NAME;
				} else {
					this.actionName = this.actionName.concat( String.valueOf(currChar) );
				}
			break;
			case TOKEN_PARAM_NAME: 
				if ( currChar == '/' || currChar == '=' ) {
					context = TOKEN_PARAM_VALUE;
				} else {
					paramName = paramName.concat( String.valueOf( currChar ) );
					
					if ( pos == ( uri.length() - 2 ) ) {
						this.params.put( paramName, paramValue );
					}
				}
			break;
			case TOKEN_PARAM_VALUE:
				if ( currChar == '/' || currChar == '&' ) {
					context = TOKEN_PARAM_NAME;
				} else {
					paramValue = paramName.concat( String.valueOf( currChar ) );
					
					if ( pos == ( uri.length() - 1 ) ) {
						this.params.put( paramName, paramValue );
					}
				}
			break;
			default:
				if ( currChar == '/' ) {
					context = TOKEN_CONTROLLER_NAME;
				}
			}
			
			pos += 1;
		}	
		
		if ( this.controllerName.length() == 0 ) {
			this.controllerName = Controller.defaultController;
		}
		
		if ( this.actionName.length() == 0 ) {
			this.actionName = Controller.defaultAction;
		}
	}
	
	public String getControllerName() {
		return this.controllerName;
	}
	
	public String getActionName() {
		return this.actionName;
	}
	
	public HashMap<String, String> getParameters() {
		return this.params;
	}
	
	public String getParameter( String name ) {
		return this.params.get(name);
	}
}
