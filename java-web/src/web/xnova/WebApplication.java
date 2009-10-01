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
			Dispatcher.getInstance().dispatch( this, request, response );
		} catch( Throwable e ) {
			this.logException( e, response.getWriter() );
		}
	}
	
	public void doPost( HttpServletRequest request, HttpServletResponse response ) throws IOException {
		try {
			Dispatcher.getInstance().dispatch( this, request, response );
		} catch ( Throwable e) {
			this.logException( e, response.getWriter() );
		}
	}
	
	protected void logException( Throwable e, PrintWriter output ) {
		if ( WebApplication.debug ) {
			e.printStackTrace( output );
		}
		
		Main.error_log.write( e.getMessage() );
		
		output.append("Sorry, probably, something going in a wrong way :( <br/>" + e.getMessage() );
	}
	
	
}
