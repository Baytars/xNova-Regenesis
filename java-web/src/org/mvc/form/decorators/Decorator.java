package org.mvc.form.decorators;

import org.mvc.form.Element;

import java.util.Comparator;

public interface Decorator {

    public static final int ORDER_FIRST = 1;
    public static final int ORDER_LAST = 2;

    public String decorate(Element element);

    public void setAttribute(String name, Object value);

    public Object getAttribute(String name);

    public int getOrder();

}
