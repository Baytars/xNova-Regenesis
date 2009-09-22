package org.uinator;

import java.util.ArrayList;

public class UI extends Widget {
	
	public ArrayList<Import> _imports;
	
	public UI() {
		this._imports = new ArrayList<Import>();
	}
	
	public Import addImport( Import imp ) {
		this._imports.add(imp);
		return imp;
	}
	
	public ArrayList<Import> getImports() {
		return _imports;
	}	
}
