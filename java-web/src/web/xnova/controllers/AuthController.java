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
	
	public void registerAction() throws PageException {
		try {
			RegisterForm form = new RegisterForm();
			form.process( this.getRequest() );
			
			this._view.setParameter("form", form);
		} catch( FormException e ) {
			this._view.setParameter("exception", new Exception().initCause(e)  );
		}
	}
	
	public void loginAction() throws PageException {
		try {
			LoginForm form = new LoginForm();
			form.process( this.getRequest() ); 
			
			this._view.setParameter("form", form);
		} catch ( FormException e ) {
			this._view.setParameter("exception", new Exception().initCause(e) );
		}
	}
	
}
