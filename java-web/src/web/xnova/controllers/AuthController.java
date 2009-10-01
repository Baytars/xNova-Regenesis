package web.xnova.controllers;

import org.mvc.controller.*;
import org.mvc.exceptions.*;

public class AuthController extends Controller {
	
	public void mainAction() throws PageException {
		throw new PageExceptionNotFound();
	}
	
	public void loginAction() {
		this._view.setParameter("password", this.getRequest().getParameter("password") );
		this._view.setParameter("login", this.getRequest().getParameter("login") );
	}
	
}
