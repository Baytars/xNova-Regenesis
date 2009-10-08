package web.xnova.controllers;

import org.mvc.*;
import org.mvc.controller.*;
import org.mvc.exceptions.*;
import org.mvc.form.*;

import web.xnova.forms.*;

public class AuthController extends Controller {
	
	public void mainAction() throws PageException {
		throw new PageExceptionNotFound();
	}
	
	public void loginAction() throws PageExceptionNotFound {
		try {
			LoginForm authForm = new LoginForm();
			
			if ( this.getRequest().getMethod().equals("POST") ) {
				authForm.process( this.getRequest() ); 
			}
			
			this._view.setParameter("loginForm", authForm);
		} catch ( Exception e ) {
			this._view.setParameter("exception", e);
		}
		
		
		this._view.setParameter("password", this.getRequest().getParameter("password") );
		this._view.setParameter("login", this.getRequest().getParameter("login") );
	}
	
}
