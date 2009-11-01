package web.xnova.forms;

import org.mvc.form.Element;
import org.mvc.form.Form;
import org.mvc.form.FormException;
import org.mvc.form.elements.PasswordField;
import org.mvc.form.elements.Submit;
import org.mvc.form.elements.TextField;
import org.mvc.validators.NotEmpty;
import web.xnova.persistence.entities.EntityException;
import web.xnova.persistence.entities.User;
import web.xnova.persistence.managers.ManagerException;
import web.xnova.persistence.managers.UserManager;

public class RegisterForm extends Form {

    public RegisterForm() {
        super();

        this.setMethod("POST")
                .setAction( this._dispatcher.routePath("/auth/register") )
                .setName("register_form");

        ( (TextField) this.addElement(new TextField("login") ) )
                .addValidator(new NotEmpty())
                .setAttribute(Element.ATTR_LABEL, "Your login");

        ( (TextField) this.addElement(new TextField("email") ) )
                .setAttribute(Element.ATTR_LABEL, "Valid e-mail")
                .addValidator(new NotEmpty());

        ( (PasswordField) this.addElement(new PasswordField("password") ) )
                .setAttribute(Element.ATTR_LABEL, "Password")
                .addValidator(new NotEmpty());

        ( (PasswordField) this.addElement(new PasswordField("retype") ) )
                .setAttribute(Element.ATTR_LABEL, "And re-type")
                .addValidator(new NotEmpty());
        ( (Submit) this.addElement(new Submit("submit") ) )
                .setValue("Process");
    }

    @Override
    protected void mainProcess() throws FormException {
        try {
            try {
                User user = UserManager.getInstance().createUser(this.getValue("login"),  this.getValue("password"), this.getValue("email") );

                this.getSession().setAttribute("user", user);

                try {
                	this._dispatcher.redirect("/user/profile");
                } catch (Exception e) {
                    throw new FormException("Redirection error");
                }
            } catch (ManagerException e) {
                this.getElement("login").addError("Database connection error!");
                throw new FormException("Database connection error");
            }
        } catch (EntityException e) {
            this.getElement("login").addError("User with such login already exists!");
        }
    }

}
