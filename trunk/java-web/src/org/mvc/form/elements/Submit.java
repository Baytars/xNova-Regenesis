package org.mvc.form.elements;

import org.mvc.form.*;
import org.mvc.form.renderers.*;

public class Submit extends Element {
	
	public Submit( String name ) {
		super();
		
		this.type = "submit";
		this.name = name;
	}

	@Override
	public Renderer createRenderer() {
		return new InputRenderer();
	}
	
}
