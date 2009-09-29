package com;

import com.ui.MainWindow;

import org.uinator.utils.Log;
import org.uinator.io.adapter.FileAdapter;

public class Application {

	public static String root_path = "./";
	
	public static Log default_logger;
	public static Log errors_logger;
	
	public static Log getErrorLog() {
		if ( null == errors_logger ) {
			errors_logger = new Log();
			errors_logger.setAdapter( new FileAdapter( Application.root_path.concat("logs/errors.log") ) );
		}
		
		return errors_logger;
	}
	
	public static Log getLog() {
		if ( null == default_logger ) {
			default_logger = new Log();
			default_logger.setAdapter( new FileAdapter( Application.root_path.concat("logs/main.log") ) );
		}
		
		return default_logger;
	}
	
    public static void start() {
        MainWindow wnd = new MainWindow();
        wnd.setVisible(true);
    }
}
