package org.mvc.controller;

import org.apache.log4j.Logger;
import org.mvc.Dispatcher;
import org.mvc.Main;
import org.mvc.exceptions.PageExceptionAccessDenied;
import org.mvc.exceptions.PageExceptionAuthRequired;
import org.mvc.exceptions.PageExceptionNotFound;
import org.mvc.view.View;

import javax.servlet.http.*;
import java.io.IOException;
import java.lang.reflect.Method;

abstract public class Controller {
    private Throwable exception;
    private View _view;

    public static String defaultAction = "main";
    public static String defaultController = "index";

    protected Dispatcher _dispatcher = Dispatcher.getInstance();
    protected static Logger log = Logger.getLogger(org.mvc.controller.Controller.class);

    public void init() throws Throwable {
        this._view = new View();
        this.exception = null;

        
        this._init();
    }

    protected void _init() {
    	Main.setCurrentLayout("default");
    }

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
        this.processPageException(new PageExceptionNotFound());
    }

    protected void processPageException( Throwable e ) {
    	log.error( e.getMessage(), e );
    }
    
    protected void processPageException( PageExceptionAuthRequired e ) {
    	try {
			this._dispatcher.redirect(Main.defaultAuthRequiredPage);
		} catch (IOException e1) {
			this.processPageException(e1);
		}
    }
    
    protected void processPageException( PageExceptionNotFound e ) {
    	try {
			this._dispatcher.redirect(Main.defaultNotFoundPage);
		} catch (IOException e1) {
			this.processPageException(e1);
		}
    }
    
    protected void processPageException( PageExceptionAccessDenied e ) {
    	try {
			this._dispatcher.redirect(Main.defaultAccessDeniedPage);
		} catch (IOException e1) {
			this.processPageException(e1);
		}
    }
    
    protected void processPageException( Object object ) {
        try {
             Method handlerMethod = this.getClass().getMethod("processPageException", new Class[] { object.getClass() } );
    
             if ( handlerMethod == null ) {
                this.processPageException(object);
             } else {
                handlerMethod.invoke(this, new Object [] { object });
             }
        } catch ( Exception e ) {
            this.processPageException( e );
        }
    }


    public View processAction(String name) {
    	try {
    		this.init();
    		
            Main.getReflectionProvider().invokeMethod(name.concat("Action"), this);
        } catch ( Throwable e) {
            this.processPageException(e);
        }

        return this.getView();
	}
	
}
