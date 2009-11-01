package web.xnova.controllers;

import org.mvc.Dispatcher;
import org.mvc.Main;
import org.mvc.controller.Controller;
import org.mvc.exceptions.PageExceptionAuthRequired;
import org.mvc.form.FormException;
import web.xnova.forms.LoginForm;
import web.xnova.forms.RegisterForm;

public class AuthController extends Controller {

    protected void _init() {
        Main.setCurrentLayout("empty");
    }

    public void mainAction() {
        this.processPageException( new PageExceptionAuthRequired() );
    }

    public void registerAction() {
        RegisterForm form = new RegisterForm();

        try {
            form.process(this.getRequest());
        } catch (Exception e) {
            this.processPageException(e);
        }

        this.getView().setParameter("form", form);
        this.getView().setParameter("pageTitle", "Sign up");
    }

    public void logoutAction() {
    	this.getSession().setAttribute("user", null);
    	
    	try {
    		this._dispatcher.redirect("/");
    	} catch ( Exception e ) {
    		this.processPageException(e);
    	}
    }
    
    public void loginAction() {
        LoginForm form = new LoginForm();

        try {
            form.process(this.getRequest());
        } catch (FormException e) {
            this.processPageException(e);
        }

        this.getView().setParameter("form", form);
        this.getView().setParameter("pageTitle", "Sign In");
    }

}
