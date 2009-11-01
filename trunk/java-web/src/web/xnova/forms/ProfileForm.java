package web.xnova.forms;

import org.mvc.form.Element;
import org.mvc.form.Form;
import org.mvc.form.FormException;
import org.mvc.form.elements.PasswordField;
import org.mvc.form.elements.Submit;
import org.mvc.form.elements.TextField;
import web.xnova.persistence.entities.User;
import web.xnova.persistence.managers.UserManager;

public class ProfileForm extends Form {

    public ProfileForm() {
        this.setMethod("POST")
                .setAction( this._dispatcher.routePath( "/user/profile") );

        this.addElement(new TextField("name"))
                .setAttribute(Element.ATTR_LABEL, "Your name")
                .setValue( this.getUser().getName() );

        this.addElement(new TextField("lastname"))
                .setAttribute(Element.ATTR_LABEL, "Your lastname")
                .setValue( this.getUser().getLastname() );

        this.addElement(new TextField("email"))
                .setAttribute(Element.ATTR_LABEL, "E-mail address")
                .setValue( this.getUser().getEmail() );

        this.addElement( new PasswordField("password") )
        		.setAttribute( Element.ATTR_LABEL, "To save changes enter your current password:");
        
        this.addElement(new Submit("submit"))
                .setValue("Save");
    }

    public User getUser() {
        return (User) this.getSession().getAttribute("user");
    }

    @Override
    protected void mainProcess() throws FormException {
        User user = this.getUser();
        user.setEmail(this.getValue("email"));

        try {
        	if ( user.checkPassword( this.getValue("password") ) ) {
        		UserManager.getInstance().save(user);
        	} else {
        		this.getElement("password").addError("Incorrect password!");
        	}
        } catch (Throwable e) {
            throw new FormException(e.getMessage());
        }
    }

} 
