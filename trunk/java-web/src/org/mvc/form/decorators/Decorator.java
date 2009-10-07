package org.mvc.form.decorators;

import org.mvc.form.*;

public interface Decorator {
	
	public String decorate( Element element );
	
	public void setAttribute( String name, Object value );
	
	public Object getAttribute( String name );
}
