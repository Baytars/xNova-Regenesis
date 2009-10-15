package web.xnova;
import javax.servlet.http.*;

import org.mvc.*;

import org.apache.log4j.*;
import java.io.IOException;

public class WebApplication extends HttpServlet {

	private static final long serialVersionUID = 1L;
	private static final boolean debug = true;
	private static final Logger log = Logger.getLogger( web.xnova.WebApplication.class );

	public void init() {
		Main.start();
		
		Dispatcher.getInstance().setControllersPackage("web.xnova.controllers");
	}

	/**
	 * Main point for all types of external requests
	 * 
	 * @param HttpServletRequest request
	 * @param HttpServletResponse response
	 * @throws IOException
	 * @return void
	 */
	public void service( HttpServletRequest request, HttpServletResponse response ) throws IOException {
		try {
			if ( !request.getRequestURI().contains(".jsp") ) {
				Dispatcher.getInstance().dispatch( this, request, response );
			}
		} catch ( Throwable e) {
			if ( WebApplication.debug ) {
				e.printStackTrace();
			}
			
			log.error( e.getMessage(), e );
		}
	}
	
	
}
