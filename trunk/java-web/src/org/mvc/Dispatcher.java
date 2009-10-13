package org.mvc;

import org.mvc.controller.Controller;
import org.mvc.http.*;
import org.mvc.utils.StringUtils;
import org.mvc.view.*;
import org.mvc.utils.*;

import javax.servlet.http.*;

import java.io.IOException;
import java.lang.reflect.InvocationTargetException;

//import java.util.Enumeration;

public class Dispatcher {
	private static Dispatcher instance;
	private String controllers_package;
	
	private HttpServletRequest request;
	private HttpServletResponse response;
	private HttpSession session;
	private HttpRouter router;
	
	/**
	 * 
	 * @return Dispatcher
	 */
	public static Dispatcher getInstance() {
		if ( instance == null ) {
			instance = new Dispatcher();
		}
		
		return instance;
	}
	
	public HttpServletRequest getRequest() {
		return this.request;
	}
	
	public HttpServletResponse getResponse() {
		return this.response;
	}
	
	public HttpSession getSession() {
		return this.session;
	}
	
	public String routePath( String path ) {
		if ( !this.getRequest().getContextPath().isEmpty() ) {
			path = this.getRequest().getContextPath().concat(path);
		}
		
		return path;
	}
	
	public void redirect( String path ) throws IOException {
		this.getResponse().sendRedirect( this.routePath( path ) );
	}
	
	public void setControllersPackage( String pkg ) {
		this.controllers_package = pkg;
	}
	
	public String getControllersPackage() {
		return this.controllers_package;
	}
	
	/**
	 * Entry point
	 * 
	 * @param servlet
	 * @param request
	 * @param response
	 * @throws IOException
	 */
	public void dispatch( HttpServlet servlet, HttpServletRequest request, HttpServletResponse response ) throws Throwable {
		this.request = request;
		this.response = response;
		this.session = request.getSession();
		this.router = new HttpRouter(request);
		
		
		Controller controller = (Controller) this.getController( this.router.getControllerName() );
		if ( controller == null ) {
			Dispatcher.getInstance().redirect( Main.defaultNotFoundPage );
		}
		
		View vc = controller.processAction( this.router.getActionName() );
		
		vc.setParameter("action", "/jsp/".concat( this.router.getControllerName() )
										 .concat("/")
										 .concat( this.router.getActionName().concat(".jsp") ) 
						);
		session.setAttribute("view", vc);
		
		request.getRequestDispatcher( 	"/jsp/layouts/".concat( Main.getCurrentLayout() ).concat(".jsp") )
			   .forward(request, response); 
	}
	
	/**
	 * Get controller by name
	 * 
	 * @param name
	 * @return
	 * @throws ClassNotFoundException
	 * @throws InstantiationException
	 * @throws InvocationTargetException
	 * @throws IllegalAccessException
	 */
	@SuppressWarnings("unchecked")
	protected Controller getController( String name ) {
		String controllerPackage = this.getControllersPackage();
		String controllerClassName = StringUtils.toCamelCase( name.concat("_controller"), "_", StringCase.UPPER);
		
		try {
			Class controllerClass = (Class) Main.getReflectionProvider().findClass( controllerClassName, controllerPackage );
			
			if ( !Main.getReflectionProvider().isParent( Controller.class, controllerClass ) ) {
				throw new ClassNotFoundException("All controller classes must be extedings from org.mvc.Controller");
			}
			
			return (Controller)Main.getReflectionProvider().createInstance(controllerClass);

		} catch( Exception e ) {
			return null;
		}
	}
	
}
