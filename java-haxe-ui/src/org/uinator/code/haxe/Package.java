package org.uinator.code.haxe;

import java.util.ArrayList;

import org.uinator.code.*;
import org.uinator.code.haxe.printers.PackagePrinter;

public class Package extends Statement {
	private String _name;
	private ArrayList<Import> _imports;
	private ArrayList<Class> _classes;
	
	public Package() {
		this._imports = new ArrayList<Import>();
		this._classes = new ArrayList<Class>();
	}
	
	public Package( String name ) {
		this();
		this._name = name;
	}
	
	public Import addImport( Import imp ) {
		this._imports.add(imp);
		
		return imp;
	}
	
	public String getName() {
		return this._name;
	}
	
	public ArrayList<Import> getImports() {
		return this._imports;
	}
	
	public Class addClass( Class cls ) {
		this._classes.add(cls);
		return cls;
	}
	
	public ArrayList<Class> getClasses() {
		return this._classes;
	}

	@Override
	public Printer getPrinter() {
		return new PackagePrinter(this);
	}

}
