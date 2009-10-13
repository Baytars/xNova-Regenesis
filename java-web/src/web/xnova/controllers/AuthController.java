package web.xnova.controllers;

import org.mvc.*;
import org.mvc.controller.*;
import org.mvc.exceptions.*;
import org.mvc.form.*;

import web.xnova.forms.*;

public class AuthController extends Controller {
	
	protected void _init() {
		Main.setCurrentLayout("empty");
	}
	
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
		
		this.getView().setParameter("form", form);
		this.getView().setParameter("pageTitle", "Sign up");
	}
	
	public void loginAction() {
		LoginForm form = new LoginForm();
		
		try {	
			form.process( this.getRequest() ); 
		} catch ( FormException e ) {
			this.setException(e);
		}
		
		this.getView().setParameter("form", form);
		this.getView().setParameter("pageTitle", "Sign In");
	}
	
}
