package org.mvc.form.decorators;

import org.mvc.form.Element;

import java.util.Comparator;
import java.util.HashMap;
import java.util.Map;


abstract public class AbstractDecorator implements Decorator {

    private Map<String, Object> attributes;

    public AbstractDecorator() {
        this.attributes = new HashMap<String, Object>();
    }

    @Override
    abstract public String decorate(Element element);

    @Override
    public Object getAttribute(String name) {
        return this.attributes.get(name);
    }

    @Override
    public void setAttribute(String name, Object value) {
        this.attributes.put(name, value);
    }

    public static Comparator<Decorator> getOrderSorter() {
        return new OrderComparator();
    }

    abstract public int getOrder();

}
