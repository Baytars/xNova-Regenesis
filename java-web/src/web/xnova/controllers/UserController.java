package web.xnova.controllers;

import org.mvc.controller.Controller;
import org.mvc.exceptions.PageExceptionAuthRequired;

import web.xnova.forms.ProfileForm;
import web.xnova.persistence.entities.User;

public class UserController extends Controller {

	public void _init() {
		if ( this.getSession().getAttribute("user") == null ) {
			this.processPageException( new PageExceptionAuthRequired() );
			return;
		}
	}
	
    public void mainAction() {
        try {
            this._dispatcher.redirect("/user/profile");
        } catch (Throwable e) {
            this.processPageException(e);
        }
    }

    public void profileAction() {
        User user = (User) this.getSession().getAttribute("user");
        if (null == user) {
            this.processPageException(new PageExceptionAuthRequired());
            return;
        }
        
        ProfileForm form = new ProfileForm();
        try {
	        form.process( this.getRequest() );
        } catch ( Exception e ) {
        	this.processPageException( e );
        }
        
        this.getView().setParameter("form", form);
    }

}
