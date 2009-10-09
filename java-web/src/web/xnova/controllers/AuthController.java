package web.xnova.controllers;

import org.mvc.*;
import org.mvc.controller.*;
import org.mvc.exceptions.*;
import org.mvc.form.*;

import web.xnova.forms.*;

public class AuthController extends Controller {
	
	public void mainAction() {
		try {
			Dispatcher.getInstance().redirect("/auth/login");
		} catch ( Exception e ) {
			this.setException(e);
		}
	}
	
	public void registerAction() {
		RegisterForm form = new RegisterForm();
		
		try {
			form.process( this.getRequest() );
		} catch ( Exception e ) {
			this.setException(e);
		}
		
		this._view.setParameter("form", form);
	}
	
	public void loginAction() {
		LoginForm form = new LoginForm();
		
		try {	
			form.process( this.getRequest() ); 
		} catch ( FormException e ) {
			this.setException(e);
		}
		
		this._view.setParameter("form", form);
	}
	
}
