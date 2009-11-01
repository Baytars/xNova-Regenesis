package web.xnova.controllers;

import org.mvc.controller.Controller;
import org.mvc.exceptions.PageExceptionAuthRequired;
import web.xnova.persistence.entities.User;

public class IndexController extends Controller {
    private User user;

    public void _init() {
        this.user = (User) this.getSession().getAttribute("user");
        if (this.user == null) {
            this.processPageException(new PageExceptionAuthRequired());
        }
    }

    @Override
    public void mainAction() {

    }
}
