package org.mvc.form.decorators;

import org.mvc.form.Element;

public class ErrorWrapper extends AbstractDecorator {

	public int getOrder() {
		return Decorator.ORDER_FIRST;
	}
	
	@Override
	public String decorate(Element element) {
		String result = new String();
		
		result = result.concat("<div class='errors'>");
		for( String error : element.getErrors() ) {
			result = result.concat("<div class='error'>").concat(error).concat("</div>");
		}
		result = result.concat("</div>");
		
		return result;
	}

}
