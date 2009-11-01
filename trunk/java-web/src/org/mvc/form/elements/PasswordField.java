package org.mvc.form.elements;

import org.mvc.form.Element;
import org.mvc.form.renderers.InputRenderer;
import org.mvc.form.renderers.Renderer;

public class PasswordField extends Element {

    public PasswordField(String name) {
        this.name = name;
        this.type = "password";
    }

    @Override
    protected Renderer createRenderer() {
        return new InputRenderer();
    }

}
