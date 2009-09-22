package com.ui;

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;
import java.io.*;
import org.uinator.Parser;
import org.uinator.code.haxe.*;

import org.uinator.UI;

public class MainWindow extends JFrame implements ActionListener {

    /**
	 * 
	 */
	private static final long serialVersionUID = 8021496943753621233L;
	private JFileChooser fc;
    private JButton fileChooseButton;
    private JButton fileCreateButton;

    public MainWindow() {
        super();

        this.setMenuBar(new MainWindowMenu(this));

        this.setTitle("UINator for HaXe");
        this.setSize(450, 600);
        this.setLayout(new BorderLayout());
        this.add(this.buildNorthPanel(), BorderLayout.NORTH);
        this.add(this.buildCenterPanel(), BorderLayout.CENTER);
        this.add(this.buildSouthPanel(), BorderLayout.SOUTH);
    }

    protected JPanel buildSouthPanel() {
        JPanel panel = new JPanel();
        panel.add(new JLabel("Developed under GNU/GPL by nikelin@strangecompany.ru"));

        return panel;
    }

    protected JPanel buildNorthPanel() {
        JPanel panel = new JPanel();

        panel.add(new JLabel("Haxe UI Development Tool"));

        return panel;
    }

    protected JPanel buildCenterPanel() {
        JPanel panel = new JPanel();
        panel.add(this.buildButtonsPanel());

        return panel;
    }

    protected JPanel buildButtonsPanel() {
        JPanel panel = new JPanel();
        panel.setLayout(new GridLayout(1, 5));
        panel.add(this.getFileChooseButton());
        panel.add(this.getFileCreateButton());

        return panel;
    }

    protected JButton getFileCreateButton() {
        if (this.fileCreateButton == null) {
            this.fileCreateButton = new JButton();

            this.fileCreateButton.setText("Create");
            this.fileCreateButton.addActionListener(this);
        }

        return this.fileCreateButton;
    }

    protected JButton getFileChooseButton() {
        if (this.fileChooseButton == null) {
            this.fileChooseButton = new JButton();
            this.fileChooseButton.setText("Choose");
            this.fileChooseButton.setSize(new Dimension(20, 300));
            this.fileChooseButton.addActionListener(this);
        }

        return this.fileChooseButton;
    }

    public void processFile(File file) {
        String data = "";

        try {
            int res = 0;
            FileReader reader = new FileReader(file);
            do {
                char buff[] = new char[2048];
                res = reader.read(buff, res, 1024);
                data = data.concat(String.valueOf(buff));
            } while (res != -1);
        } catch (Exception e) {
            showException("Error while proceeding file ( check it's validity )");
        }

        Parser parser = new Parser();

        try {
            UI resultObject = parser.parse(file);

            // @TODO: configuring codegeneration issues
//			CodegenerationConfigWindow configWnd = new CodegenerationConfigWindow();
//			configWnd.setVisible(true);

            HaxeGenerator generator = new HaxeGenerator();
            System.out.println(generator.process(resultObject));
        } catch (Exception e) {
            e.printStackTrace();
            showException("Document parsing error... See to log");
        }
    }

    public static void showException(String message) {
        JFrame wnd = new JFrame();
        wnd.setSize(300, 60);
        wnd.setTitle("Unexpected exception!");
        wnd.add(new JLabel(message));

        wnd.setVisible(true);
    }

    public void actionPerformed(ActionEvent e) {
        if (e.getSource() == this.fileChooseButton) {
            com.commands.UXMLFileOpen.play(this);
        } else if (e.getSource() == this.fileCreateButton) {
            System.out.println("Create new file");
        }
    }
}
