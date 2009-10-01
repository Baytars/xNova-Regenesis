package org.mvc.view;

import java.io.IOException;
import java.util.Enumeration;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;


abstract public class AbstractView implements HttpJspPage {

    private ServletConfig config;
    
    abstract public void _jspService(HttpServletRequest request,
	    HttpServletResponse response) throws ServletException, IOException;

    @Override
	final public void service(ServletRequest req, ServletResponse res)
        throws ServletException, IOException {
        // casting exceptions will be raised if an internal error.
        HttpServletRequest request = (HttpServletRequest) req;
        HttpServletResponse response = (HttpServletResponse) res;
        
        _jspService(request, response);
   }

	@Override
	public void jspDestroy() {}

	@Override
	public void jspInit() {}

	@Override
	public void destroy() {
		jspDestroy();
	}


	@Override
	public ServletConfig getServletConfig() {
		return this.config;
	}


	@Override
	public String getServletInfo() {
		return "Abstract JSP view class";
	}


	@Override
	public void init(ServletConfig config) throws ServletException {
		this.config = config;
		
		this.jspInit();
	}


}
