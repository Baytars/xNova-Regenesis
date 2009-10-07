package org.mvc.form.validators;

import java.util.List;

public interface Validator {
	
	public List<String> getMessages();
	
	public boolean validate( Object value );
}
