package org.mvc.controller;

import javax.servlet.http.*;

import org.mvc.view.*;
import org.mvc.*;
import org.mvc.exceptions.*;

abstract public class Controller {
	protected View _view;
	private HttpServletRequest _request;
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
	
	public void setRequest( HttpServletRequest request ) {
		this._request = request;
	}
	
	public HttpServletRequest getRequest() {
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
