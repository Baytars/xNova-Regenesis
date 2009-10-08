package web.xnova.forms;

import org.mvc.*;
import org.mvc.form.*;
import org.mvc.validators.*;
import org.mvc.form.elements.*;
import web.xnova.persistence.managers.*;
import web.xnova.persistence.entities.*;;

public class RegisterForm extends Form {

	public RegisterForm() throws FormException {
		super();
		 
		this.setMethod("POST") 
			.setAction( Dispatcher.getInstance().getRequest().getContextPath().concat("/auth/register") )
			.setName("register_form"); 
		
		TextField login = (TextField) this.addElement( new TextField("login") )
										  .addValidator(new NotEmpty())
										  .setAttribute( Element.ATTR_LABEL, "Your login");
		
		TextField email = (TextField) this.addElement( new TextField("email") )
										  .setAttribute( Element.ATTR_LABEL, "Valid e-mail")
										  .addValidator( new NotEmpty() );
		
		PasswordField password = (PasswordField) this.addElement( new PasswordField("password") )
													 .setAttribute( Element.ATTR_LABEL, "Password")
													 .addValidator( new NotEmpty() );
		
		PasswordField retype = (PasswordField) this.addElement( new PasswordField("retype") )
												   .setAttribute(Element.ATTR_LABEL, "And re-type")
												   .addValidator( new NotEmpty() );
		Submit submit = (Submit) this.addElement( new Submit("submit") )
									 .setValue("Process" )
									 ;
	}
	
	@Override
	protected void mainProcess() throws FormException {
		try {
			try {
				User user = UserManager.getInstance().createUser( this.getValue("login"), this.getValue("email"), this.getValue("password") );
				
				Dispatcher.getInstance().getSession().setAttribute("user", user);
				
				try {
					Dispatcher.getInstance().getResponse().sendRedirect("/user/profile");
				} catch ( Exception e ) {
					throw new FormException("Redirection error");
				}
			} catch ( ManagerException e ) {
				throw new FormException("Database connection error");
			}
		} catch ( EntityException e ) {
			this.getElement("login").addError( e.getMessage() );
		}
	}

}