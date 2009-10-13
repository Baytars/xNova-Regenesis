package web.xnova.forms;

import java.io.IOException;

import org.mvc.Dispatcher;
import org.mvc.form.*;

import org.mvc.form.elements.*;
import org.mvc.validators.*;

import web.xnova.persistence.managers.*;
import web.xnova.persistence.entities.User;

public class LoginForm extends Form {
	
	public LoginForm() {
		super();
		
		this.setAction( Dispatcher.getInstance().getRequest().getContextPath().concat( "/auth/login") );
		this.setMethod("POST");
		
		TextField loginEl = (TextField) this.addElement( new TextField("login") );
		loginEl.addValidator( new NotEmpty() )
			   .setAttribute(Element.ATTR_LABEL, "Enter your login");
		
		PasswordField passwordEl = (PasswordField) this.addElement( new PasswordField("password") );
		passwordEl.setAttribute(Element.ATTR_LABEL, "And password")
				  .addValidator( new NotEmpty() );
		
		Submit submitBtn = (Submit) this.addElement( new Submit("submit") );
		submitBtn.setValue("Sign In");
	}
	
	@Override
	protected void mainProcess() throws FormException {
		try {
			User u = UserManager.getInstance().findByCredentials( this.getValue("login"), this.getValue("password") );
			if ( u != null ) {
				this.getSession().setAttribute("user", u);
				
				try {
					this.getResponse().sendRedirect("/user/profile");
				} catch( IOException e ) {
					throw new FormException( e.getMessage() );
				}
			} else {
				this.getElement("login").addError("User with such login or password is not founds!");
			}
		} catch( ManagerException e ) {
			throw new FormException("Database error!");
		}
	}
}
