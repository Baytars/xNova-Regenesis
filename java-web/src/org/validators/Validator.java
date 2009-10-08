package org.mvc.validators;

import java.util.List;

public interface Validator {
	
	public static String EMPTY_VALUE_ERROR = "Field must contains value!";
	
	public String getMessage();
	
	public boolean validate( Object value );
}
