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
	
	public void init() {
	}
	
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
		HttpRequest req = new HttpRequest( request ); 
		
//		Enumeration<String> params = request.getParameterNames();
//		for( String param = params.nextElement(); params.hasMoreElements(); param = params.nextElement() ) {
//			if ( param.equals("route") ) {
//				this.routeRequest( request.getParameter(param), req );
//			}
//		}
		
		Controller controller = (Controller) this.getController( req.getControllerName() );
		controller.init();
		controller.setRequest(req);
		
		View vc = controller.processAction( req.getActionName() );
		/**
		 * @FIXME replace with regexp matching
		 */
		vc.setScriptPath( Main.root_path.concat("/views/")
										.concat( req.getControllerName() )
										.concat("/")
										.concat( req.getActionName() )
										.concat(".jsp") );
		
		vc.service( request, response );
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
	protected Controller getController( String name ) throws ClassNotFoundException, 
															 InstantiationException, 
															 InvocationTargetException, 
															 IllegalAccessException
	{
		Controller result = null;
		String controllerPackage = this.getControllersPackage();
		String controllerClassName = StringUtils.toCamelCase( name.concat("_controller"), "_", StringCase.UPPER);
		
		Class controllerClass = (Class) Main.getReflectionProvider().findClass( controllerClassName, controllerPackage );
		if ( controllerClass == null ) {
			return result;
		}
		
		if ( !Main.getReflectionProvider().isParent( Controller.class, controllerClass ) ) {
			throw new ClassNotFoundException("All controller classes must be extedings from org.mvc.Controller");
		}
		
		return (Controller)Main.getReflectionProvider().createInstance(controllerClass);
	}
	
	/**
	 * Process user request throught routerClass given from servlet context
	 * 
	 * @param routerClass
	 * @param request
	 */
	protected void routeRequest( String routerClass, HttpRequest request ) {
		
	}
}
