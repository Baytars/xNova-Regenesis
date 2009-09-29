package com.ui;

import javax.swing.*;
import javax.swing.text.JTextComponent;

import com.Application;
import com.commands.*;
import com.ui.highlighters.*;

import java.awt.BorderLayout;
import java.awt.GridLayout;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.awt.event.MouseAdapter;
import java.awt.event.MouseEvent;

import java.io.File;
import java.io.FileReader;

public class EditWindow extends JFrame implements Commander {

	private JPopupMenu contextMenu;
	private JTextArea codeArea;
	
	protected String copy_buff;
	
	public EditWindow() {
		this.setTitle("UXML Editor");
		
		this.setSize( 500, 600 );
		
		this.initUI();
	}
	
	public void processCommand( CommandType ct, Object data ) {
		try {
			switch(ct) {
			case UXML_FILE_OPEN:
		        String text = new String();
	
	            int res = 0;
	            FileReader reader = new FileReader( (File)data );
	            do {
	                char buff[] = new char[2048];
	                res = reader.read(buff, res, 1024);
	                text = text.concat( String.valueOf(buff) );
	            } while (res != -1);
		            
		        this.codeArea.setText( text );
		        new UXMLHighlighter().highlight( this.codeArea, new UXMLTokenizer() );
			break;
			}
		} catch( Exception e ) {
			MainWindow.showException( "Cannot read file", e );
		}
	}
	
	protected void showContextMenu( JTextComponent context, int x, int y) {
		if( null == this.contextMenu ) {
			this.contextMenu = new JPopupMenu();
			this.contextMenu.setSize(150, 500);
			
			this.contextMenu.add( new CopyAction(context) );
			this.contextMenu.add( new CutAction(context) );
			this.contextMenu.add( new PasteAction(context) );
			this.contextMenu.addSeparator();
			this.contextMenu.add( new FormatAction(context) );
		}
		
		this.contextMenu.show( context, x, y);
	}
	
	protected void initUI() {
		JPanel mainPanel = new JPanel();
		mainPanel.setLayout( new BorderLayout() );
		
		this.codeArea = new JTextArea();
		this.codeArea.addMouseListener( new MouseAdapter() {
			@Override
			public void mouseClicked(MouseEvent e) {
				super.mouseClicked(e);
				
				if ( e.getButton() == MouseEvent.BUTTON3 ) {
					EditWindow.this.showContextMenu( EditWindow.this.codeArea, e.getX(), e.getY() );
				}
			}
		});
		
		mainPanel.add( this.codeArea, BorderLayout.CENTER );
		
		JPanel controlsPanel = new JPanel();
		controlsPanel.setLayout( new GridLayout(2, 1) );
		
		JButton openBtn = new JButton("Open");
		openBtn.addActionListener( new ActionListener() {

			@Override
			public void actionPerformed(ActionEvent arg0) {
				UXMLFileOpen.play(EditWindow.this);
			}
			
		});
		JButton saveBtn = new JButton("Save");
		saveBtn.addActionListener( new ActionListener() {
			@Override
			public void actionPerformed( ActionEvent arg0 ) {
				Application.getLog().write("Trying to save document");
				//UXMLFileSave.play( EditWindow.this,  );
			}
		});
		
		controlsPanel.add( openBtn );
		controlsPanel.add( saveBtn );
		
		mainPanel.add( controlsPanel, BorderLayout.NORTH );
		
		this.add(mainPanel);
	}
	
	class CutAction extends AbstractAction {
		private JTextComponent tc;
		
		public CutAction( JTextComponent tc ) {
			super("Cut");
			
			this.tc =tc;
		}

		@Override
		public void actionPerformed(ActionEvent arg0) {
			int selEnd = this.tc.getSelectionEnd();
			int selStart = this.tc.getSelectionStart();
			
			try {
				EditWindow.this.copy_buff = this.tc.getText( selStart, selEnd - this.tc.getText().length() );
			} catch ( Exception e ) {
				
			}
			
			this.tc.replaceSelection("");
		}
	}
	
	class PasteAction extends AbstractAction {
		private JTextComponent tc;
		
		public PasteAction( JTextComponent tc ) {
			super("Paste");
			
			this.tc =tc;
		}

		@Override
		public void actionPerformed(ActionEvent arg0) {
			this.tc.replaceSelection(EditWindow.this.copy_buff);
			EditWindow.this.copy_buff = "";
		}
	}
	
	class CopyAction extends AbstractAction {
		private JTextComponent tc;
		
		public CopyAction( JTextComponent tc ) {
			super("Copy");
			
			this.tc =tc;
		}

		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			
		}
	}
	
	class FormatAction extends AbstractAction {
		private JTextComponent tc;
		
		public FormatAction( JTextComponent tc ) {
			super("Format");
			
			this.tc =tc;
		}

		@Override
		public void actionPerformed(ActionEvent arg0) {
			// TODO Auto-generated method stub
			
		}
	}
	
}
