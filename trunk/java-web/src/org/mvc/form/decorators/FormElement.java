package org.mvc.form.decorators;

import org.mvc.form.Element;

public class FormElement extends AbstractDecorator {

	@Override
	public String decorate(Element element ) {
		String result = new String();
		 
		String label = (String) element.getAttribute(Element.ATTR_LABEL);
		if( label == null ) {
			label = new String();
		}
		
		result = result.concat("<dt>")
					   .concat("<dl>").concat( label ).concat(": </dl>")
					   .concat("<dl>").concat( element.getRendered() ).concat("</dl>")
					   .concat("</dt>");
		
		return result;
	}


}
