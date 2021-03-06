package org.mvc.form.renderers;

import org.mvc.form.Element;
import org.mvc.form.Form;

public class FormRenderer implements Renderer {

    public String render(Element e) {
        Form element = (Form) e;

        String result = new String();
        result = result.concat("<form ");

        if (element.getId() != null) {
            result = result.concat("id='").concat(element.getId()).concat("' ");
        }

        if (element.getAction() != null) {
            result = result.concat("action='").concat(element.getAction()).concat("' ");
        }

        if (element.getMethod() != null) {
            result = result.concat("method='").concat(element.getMethod()).concat("' ");
        }
        //...
        result = result.concat(">");

        if (!element.getElements().isEmpty()) {
            for (Element child : element.getElements()) {
                String childResult = child.render();

                if (childResult != null) {
                    result = result.concat(child.render());
                }
            }
        }

        result = result.concat("</form>");

        return result;
    }

}
