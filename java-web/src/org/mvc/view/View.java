package org.mvc.view;

import java.io.IOException;
import java.io.File;
import java.io.FileReader;
import java.util.HashMap;

import javax.servlet.*;
import javax.servlet.http.*;
import javax.servlet.jsp.*;

import org.mvc.Main;

public class View extends AbstractView {
	public static String defaultEncoding = "UTF-8";
	public static String defaultContentType = "text/html";
	
	private String contentType;
	private String encoding;
	
	private int buffer_size;
	private String script_path;
	private String body;
	private String error_page;
	private HashMap<String, Object> parameters;
	
	public View() {
		this.contentType = View.defaultContentType;
		this.encoding = View.defaultEncoding;
		
		this.body = new String();
		this.script_path = new String();
		this.buffer_size = 9000;
		this.error_page = Main.defaultNotFoundPage;
		this.error_page = new String();
		this.parameters = new HashMap<String, Object>();
	}
	
	public void setContentType( String type) {
		this.contentType = type;
	}
	
	public void setEncoding( String encoding ) {
		this.encoding = encoding;
	}
	
	public void setParameter( String name, Object value ) {
		this.parameters.put(name, value);
	}
	
	public Object getParameter( String name ) {
		return this.parameters.get(name);
	}
	
	public HashMap<String, Object> getParameters() {
		return this.parameters;
	}
	
	public void setScriptPath( String path ) {
		this.script_path = path;
	}
	
	public String getScriptPath() {
		return this.script_path;
	}
	
	protected String getBody() throws IOException {
		if ( this.body == null ) {
			File scriptFile = new File( this.getScriptPath() );
			
			if ( !scriptFile.isFile() ) {
				throw new IOException("View script file does not exists");
			}
				
			FileReader reader = new FileReader( scriptFile );
	        int res = 0;
	        do {
	            char buff[] = new char[2048];
	            res = reader.read(buff, res, 1024);
	            this.body = this.body.concat(String.valueOf(buff));
	        } while (res != -1);
		}
		
		return this.body;
	}
	
	
	public void setErrorPage( String url ) {
		this.error_page = url;
	}
	
	public String getErrorPage() {
		return this.error_page;
	}
	
	public int getBufferSize() {
		return this.buffer_size;
	}
	
	public void setBufferSize( int size) {
		this.buffer_size = size;
	}
	
	@Override
	public void _jspService( HttpServletRequest request, HttpServletResponse response ) throws ServletException, IOException {
	    PageContext pageContext = null;
	    HttpSession session = null;
	    ServletContext application = null;
	    ServletConfig config = null;

	    JspWriter out = null;
	    JspFactory jspFactory = null;
	    try {
	        jspFactory = JspFactory.getDefaultFactory();
	
	        response.setContentType(this.contentType.concat(";charset=").concat(this.encoding) );
	        pageContext = jspFactory.getPageContext(this, request, response,
	                    this.getErrorPage(), true, this.getBufferSize(), true);
	
	        application = pageContext.getServletContext();
	        config = pageContext.getServletConfig();
	        session = pageContext.getSession();
	        out = pageContext.getOut();
	        
	        HashMap<String, Object> params = this.getParameters();
	        if ( !params.isEmpty() ) {
		        for ( String key : params.keySet() ) {
		        	pageContext.setAttribute( key, params.get(key) );
		        }
	        }
	        
	        out.write( this.getBody() );
	    } catch (Throwable t) {
	        if (out != null && out.getBufferSize() != 0)
	            out.clearBuffer();
	        
	        t.printStackTrace(response.getWriter());
	        
	        throw new ServletException(t.getMessage());
	    } finally {
	        if (jspFactory != null) 
	        	jspFactory.releasePageContext(pageContext);
	    }
	}

	
}