package org.mvc.controller;

import java.io.IOException;

import javax.servlet.http.*;

import org.apache.log4j.Logger;
import org.mvc.view.*;
import org.mvc.*;
import org.mvc.exceptions.*;

abstract public class Controller {
	private Throwable exception;
	private View _view;
	
	public static String defaultAction = "main";
	public static String defaultController = "index";
	
	protected static Logger log = Logger.getLogger( org.mvc.controller.Controller.class );
	
	public void init() {
		this._view = new View();
		this.exception = null;
		
		this._init();
	}
	
	protected void _init() {}
	
	public HttpServletResponse getResponse() {
		return Dispatcher.getInstance().getResponse();
	}
	
	public HttpServletRequest getRequest() {
		return Dispatcher.getInstance().getRequest();
	}
	
	public HttpSession getSession() {
		return Dispatcher.getInstance().getSession();
	}
	
	public View getView() {
		return this._view;
	}
	
	public void mainAction() {
		this.setException( new PageExceptionNotFound() );
	}
	
	protected void processPageException( Throwable e ) throws Throwable {
		if ( e instanceof PageExceptionAuthRequired ) {
			Dispatcher.getInstance().redirect( Main.defaultAuthRequiredPage );
		} else if ( e instanceof PageExceptionNotFound ) {
			Dispatcher.getInstance().redirect( Main.defaultNotFoundPage );
		} else if ( e instanceof PageExceptionAccessDenied ){
			Dispatcher.getInstance().redirect( Main.defaultAccessDeniedPage );
		} else {
			log.error( e.getMessage(), e );
		}
	}
	
	
	/**
	 * Hook to handle exceptions from concrete actions, because
	 * Java "eats" all throwed exceptions from invoked by reflection
	 * methods.
	 * 
	 * @param e
	 * @return Controller
	 */
	public Controller setException( Throwable e ) {
		this.exception = e;
		return this;
	}
	
	public Throwable getException() {
		return this.exception;
	}
	
	public View processAction( String name ) throws Throwable {
		this.init();
		
		try {
			Main.getReflectionProvider().invokeMethod( name.concat("Action"), this );
		} catch ( Exception e ) {
			this.setException( new PageExceptionNotFound() );
		}
		
		if ( this.getException() != null ) {
			this.getView().setParameter("exception", this.getException() );
			this.processPageException( this.getException() );
		}
		
		return this.getView();
	}
	
}
