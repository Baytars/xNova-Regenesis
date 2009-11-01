package org.mvc.form.decorators;

import org.mvc.form.Element;

public class FormElement extends AbstractDecorator {

    public int getOrder() {
        return Decorator.ORDER_LAST;
    }

    @Override
    public String decorate(Element element) {
        String result = new String();

        String label = (String) element.getAttribute(Element.ATTR_LABEL);
        if (label == null) {
            label = new String();
        }

        result = result.concat("<dd>")
                .concat("<dl>").concat(label).concat(label.length() != 0 ? ":" : "").concat("</dl>")
                .concat("<dt>").concat(element.getRendered()).concat("</dt>")
                .concat("</dd>");

        return result;
    }


}
