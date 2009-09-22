package com.commands;
import javax.swing.JFileChooser;
import com.ui.MainWindow;

public class UXMLFileOpen {
	
	public static void play( MainWindow context ) {
		JFileChooser fc = new JFileChooser();
		fc.setFileSelectionMode(JFileChooser.FILES_AND_DIRECTORIES);
		//fc.setFileFilter( new UxmlFileFilter() );
		
		int ret = fc.showOpenDialog(context);
		if ( ret == JFileChooser.APPROVE_OPTION ) {
			context.processFile( fc.getSelectedFile() );
		}	
	}

	
}
