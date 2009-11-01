package org.mvc.form.renderers;

import org.mvc.form.Element;

public class InputRenderer implements Renderer {

    public String render(Element e) {
        String result = new String();

        result = result.concat("<input ")
                .concat("name='").concat(e.getName()).concat("' ")
                .concat("id='").concat(e.getId()).concat("' ");

        if (e.getType() != null) {
            result = result.concat("type='").concat(e.getType()).concat("' ");
        }

        if (e.getValue() != null) {
            result = result.concat("value='").concat(e.getValue()).concat("' ");
        }

        if (!e.getAttributes().isEmpty()) {
            for (String name : e.getAttributes().keySet().toArray(new String[e.getAttributes().size()])) {
                Object value = e.getAttribute(name);
                if (value instanceof CharSequence) {
                    result = result.concat(name).concat("='").concat((String) value).concat("' ");
                }
            }
        }

        result = result.concat("/>");

        return result;
    }
}
