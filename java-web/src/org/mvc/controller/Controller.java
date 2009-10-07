package org.mvc.controller;

import java.lang.reflect.InvocationTargetException;

import javax.servlet.http.*;

import org.mvc.utils.StringCase;
import org.mvc.utils.StringUtils;
import org.mvc.view.*;
import org.mvc.http.*;
import org.mvc.*;
import org.mvc.exceptions.*;

abstract public class Controller {
	protected View _view;
	private HttpRequest _request;
	private HttpServletResponse _response;
	
	public static String defaultAction = "main";
	public static String defaultController = "index";
	
	public void init() {
		this._view = new View();
	}
	
	public void setResponse( HttpServletResponse response ) {
		this._response = response;
	}
	
	public HttpServletResponse getResponse() {
		return this._response;
	}
	
	public void mainAction() throws PageException {
		throw new PageExceptionNotFound();
	}
	
	public void setRequest( HttpRequest request ) {
		this._request = request;
	}
	
	public HttpRequest getRequest() {
		return this._request;
	}
	
	protected void processPageException( Exception e ) {
		Main.error_log.write( e.getMessage() );
	}
	
	protected void processPageException( PageExceptionAccessDenied e ) {
		this.getResponse().encodeRedirectURL( Main.defaultAccessDeniedPage );
	}
	
	protected void processPageException( PageExceptionAuthRequired e ) {
		this.getResponse().encodeRedirectURL( Main.defaultAuthRequiredPage );
	}
	
	protected void processPageException( PageExceptionNotFound e ) {
		this.getResponse().encodeRedirectURL( Main.defaultNotFoundPage );
	}
	
	public View processAction( String name ) throws Exception {
		try {
			Main.getReflectionProvider().invokeMethod( name.concat("Action"), this, null );
			
			return this._view;
		} catch ( Exception e ) {
			this.processPageException(e);
			
			throw(e);
		}
	}
	
}
