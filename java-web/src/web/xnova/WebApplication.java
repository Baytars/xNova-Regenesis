package web.xnova;
import javax.servlet.http.*;

import org.mvc.*;

import java.io.IOException;
import java.io.PrintWriter;

public class WebApplication extends HttpServlet {

	private static final long serialVersionUID = 1L;
	private static final boolean debug = true;

	public void init() {
		Main.start();
		
		Dispatcher.getInstance().setControllersPackage("web.xnova.controllers");
	}
	
	public void doGet( HttpServletRequest request, HttpServletResponse response ) throws IOException {
		try {
			if ( !request.getRequestURI().contains(".jsp") ) {
				Dispatcher.getInstance().dispatch( this, request, response );
			}
		} catch( Throwable e ) {
			this.logException( e, response.getWriter() );
		}
	}
	
	public void doPost( HttpServletRequest request, HttpServletResponse response ) throws IOException {
		try {
			if ( !request.getRequestURI().contains(".jsp") ) {
				Dispatcher.getInstance().dispatch( this, request, response );
			}
		} catch ( Throwable e) {
			this.logException( e, response.getWriter() );
		}
	}
	
	protected void logException( Throwable e, PrintWriter output ) {
		if ( WebApplication.debug ) {
			if ( output != null ) {
				e.printStackTrace( output );
			} else {
				e.printStackTrace();
			}
		}
		
		Main.error_log.error( e.getMessage(), e );
	}
	
	
}
