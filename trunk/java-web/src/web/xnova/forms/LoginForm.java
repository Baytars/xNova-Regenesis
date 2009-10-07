package web.xnova.forms;

import org.mvc.form.*;
import org.mvc.form.elements.*;

public class LoginForm extends Form {
	
	public LoginForm() throws FormException {
		super();
		
		this.setAction("/auth/login");
		this.setMethod("POST");
		
		TextField loginEl = (TextField) this.addElement( new TextField("login") );
		loginEl.setAttribute(Element.ATTR_LABEL, "Enter your login");
		
		TextField passwordEl = (TextField) this.addElement( new TextField("password") );
		passwordEl.setAttribute(Element.ATTR_LABEL, "And password");
		
		Submit submitBtn = (Submit) this.addElement( new Submit("submit") );
		submitBtn.setValue("Sign In");
	}
	
	public Result process() {
		return null;
	}
	
}
