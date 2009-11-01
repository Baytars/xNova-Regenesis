package org.mvc.form.elements;

import org.mvc.form.Element;
import org.mvc.form.renderers.InputRenderer;
import org.mvc.form.renderers.Renderer;

public class TextField extends Element {

    public TextField(String name) {
        this.name = name;
        this.type = "text";
    }

    protected Renderer createRenderer() {
        return new InputRenderer();
    }

}
