package web.xnova.forms;

import org.mvc.Dispatcher;
import org.mvc.form.*;
import org.mvc.http.*;

import org.mvc.form.elements.*;
import org.mvc.validators.*;

public class LoginForm extends Form {
	
	public LoginForm() throws FormException {
		super();
		
		this.setAction( Dispatcher.getInstance().getRequest().getContextPath().concat( "/auth/login") );
		this.setMethod("POST");
		
		TextField loginEl = (TextField) this.addElement( new TextField("login") );
		loginEl.addValidator( new NotEmpty() )
			   .setAttribute(Element.ATTR_LABEL, "Enter your login");
		
		TextField passwordEl = (TextField) this.addElement( new TextField("password") );
		passwordEl.setAttribute(Element.ATTR_LABEL, "And password")
				  .addValidator( new NotEmpty() );
		
		Submit submitBtn = (Submit) this.addElement( new Submit("submit") );
		submitBtn.setValue("Sign In");
	}
	
	@Override
	protected void mainProcess() throws FormException {

	}
}
