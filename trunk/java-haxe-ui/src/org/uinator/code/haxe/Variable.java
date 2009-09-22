package org.uinator.code.haxe;

import org.uinator.code.*;
import org.uinator.code.haxe.printers.VariablePrinter;

public class Variable extends Statement {
	
	private String _name;
	private String _type;
	private String _value;
	
	public Variable( String name, String type, String value ) {
		this._name = name;
		this._value = value;
		this._type = type;
	}
	
	public String getName() {
		return this._name;
	}
	
	public String getType() {
		return this._type;
	}
	
	public String getValue() {
		return this._value;
	}
	
	public Printer getPrinter() {
		return new VariablePrinter(this);
	}
}
