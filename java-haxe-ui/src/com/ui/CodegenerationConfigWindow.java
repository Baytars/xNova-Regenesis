package com.ui;

import javax.swing.JCheckBox;
import javax.swing.JFrame;
import javax.swing.JRadioButton;
import javax.swing.JButton;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JRadioButtonMenuItem;
import javax.swing.JFileChooser;

import java.awt.BorderLayout;
import java.awt.GridLayout;

public class CodegenerationConfigWindow extends JFrame {

	/**
	 * 
	 */
	private static final long serialVersionUID = -5262747335759871315L;

	public CodegenerationConfigWindow() {
		super();
		
		this.setTitle("Codegeneration options");
		this.setSize( 500, 400 );
		this.setLayout( new BorderLayout() );
		
		this.initUI();
	}
	
	protected void initUI() {
		this.add( this.getCenterPanel(), BorderLayout.CENTER );
		this.add( this.getSouthPanel(), BorderLayout.SOUTH );
	}
	
	protected JPanel getCenterPanel() {
		JPanel panel = new JPanel();
		panel.setLayout( new GridLayout(8, 1) );
		
		JPanel haxeVersionPanel = new JPanel();
		haxeVersionPanel.add( new JLabel("HaXe compiler version:") );
		haxeVersionPanel.add( new JRadioButton("2.0", true ) );
		haxeVersionPanel.add( new JRadioButton("3.0", false ) );
		panel.add( haxeVersionPanel );
		
		JPanel asVersionPanel = new JPanel();
		asVersionPanel.add( new JLabel("ActionScript version:") );
		asVersionPanel.add( new JRadioButton("3.0", true ) );
		asVersionPanel.add( new JRadioButton("2.0", true ) );
		panel.add( asVersionPanel );
		
		panel.add( new JCheckBox("Compile to SWF?", true ) );
		panel.add( new JFileChooser() );
		
		return panel;
	}
	
	protected JPanel getSouthPanel() {
		JPanel panel = new JPanel();
		
		panel.add( new JButton("Process") );
		panel.add( new JButton("Cancel") );
		
		return panel;
	}
	
}
