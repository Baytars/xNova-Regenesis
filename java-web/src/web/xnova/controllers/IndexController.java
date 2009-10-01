package web.xnova.controllers;

import org.mvc.controller.Controller;
import org.mvc.view.View;
import org.mvc.exceptions.*;

public class IndexController extends Controller {
	
	public void indexAction() {
		
	}

	@Override
	public void mainAction() throws PageException {
		this._view.setParameter("Afla", "afxl");
		this._view.setParameter("Afla2", "234412412");
	}
}
