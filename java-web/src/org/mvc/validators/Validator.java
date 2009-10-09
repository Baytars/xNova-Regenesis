package org.mvc.validators;

public interface Validator {
	
	public static String EMPTY_VALUE_ERROR = "Field must contains value!";
	
	public String getMessage();
	
	public boolean validate( Object value );
}
