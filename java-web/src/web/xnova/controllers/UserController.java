package web.xnova.controllers;

import org.mvc.*;
import org.mvc.controller.*;
import org.mvc.exceptions.PageExceptionAuthRequired;

import web.xnova.persistence.entities.User;

public class UserController extends Controller {
	
	public void mainAction() {
		try {
			this.getResponse().sendRedirect("/user/profile");
		} catch ( Throwable e ) {
			this.setException(e);
		}
	}
	
	public void profileAction() {
		User user = (User) this.getSession().getAttribute("user");
		if ( null == user ) {
			this.setException( new PageExceptionAuthRequired() );
		}
		
		this.getView().setParameter("user", user );
	}
	
}
