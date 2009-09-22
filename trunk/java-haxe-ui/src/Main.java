/**
 * Main class
 * 
 * @author nikelin
 */

import com.WindowApplication;
import com.ui.MainWindow;

import org.uinator.utils.*;
import java.io.File;

public class Main {

    protected static Log createDefaultLogger() {
        Log logger = new Log();
        logger.setAdapter( new org.uinator.io.adapter.FileAdapter( ( (String) Registry.get("root_path") ).concat("/logs/mail.log") ) );
        logger.setDebug( true );

        return logger;
    }

    protected static Log createErrorLogger() {
        Log logger = new Log();
        logger.setAdapter( new org.uinator.io.adapter.FileAdapter( ( (String) Registry.get("root_path") ).concat("/logs/errors.log") ) );
        logger.setDebug( true );

        return logger;
    }

    public static void main(String args[]) {
        try {
            Registry.set("root_path", new File(".").getCanonicalPath() );
            Registry.set("error_log", createErrorLogger() );
            Registry.set("log", createDefaultLogger() );

            WindowApplication.start();
        } catch ( Exception e ) {
            ( (Log)Registry.get("log") ).write( e );
            MainWindow.showException( "Error!!!" );
        }
    }
}
