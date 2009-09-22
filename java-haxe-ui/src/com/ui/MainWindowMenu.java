package com.ui;

import java.awt.Menu;
import java.awt.MenuItem;
import java.awt.MenuBar;
import java.awt.event.ActionListener;
import java.awt.event.ActionEvent;
import com.commands.UXMLFileOpen;
import com.ui.MainWindow;

public class MainWindowMenu extends MenuBar implements ActionListener {
	private Menu fileMenu;
	private MainWindow parent;
	
	public MainWindowMenu( MainWindow parent ) {
		this.parent = parent;
		
		fileMenu = new Menu("File");
		fileMenu.setName("fileMenu");
		fileMenu.add( new MenuItem("New") );
		fileMenu.add( new MenuItem("Open") );
		fileMenu.add( new MenuItem("Exit") );
		
		fileMenu.addActionListener( this );
		
		this.add( fileMenu );
	}
	
	public void actionPerformed( ActionEvent e ) {
		if ( e.getSource() == this.fileMenu ) {
			if ( e.getActionCommand() == "New" ) {
				UXMLFileOpen.play(this.parent);
			}
		}	
	}
	
}
