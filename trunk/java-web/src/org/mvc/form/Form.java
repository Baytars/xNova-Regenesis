package org.mvc.form;

import org.mvc.Dispatcher;
import org.mvc.form.renderers.FormRenderer;
import org.mvc.form.renderers.Renderer;

import javax.servlet.http.*;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.List;
import java.util.Map;


abstract public class Form extends Element {

    private List<Element> elements;
    private String action;
    private String method;
    
    protected Dispatcher _dispatcher = Dispatcher.getInstance();

    public Form() {
        this.elements = new ArrayList<Element>();

        this.removeDecorators();
    }

    public Form setAction(String action) {
        this.action = action;
        return this;
    }

    public String getAction() {
        return this.action;
    }

    public String getMethod() {
        return this.method;
    }

    protected HttpServletRequest getRequest() {
        return Dispatcher.getInstance().getRequest();
    }

    protected HttpServletResponse getResponse() {
        return Dispatcher.getInstance().getResponse();
    }

    protected HttpSession getSession() {
        return Dispatcher.getInstance().getSession();
    }

    public Form setMethod(String method) {
        this.method = method;
        return this;
    }

    public boolean isValid() {
        boolean result = true;
        for (Element el : this.getElements()) {
            if (!el.isValid()) {
                this.markAsError();
                result = false;
                break;
            }
        }

        return result;
    }

    protected void initValues(Map<String, String> values) {
        for (Object key : values.keySet().toArray()) {
            String name = (String) key;

            Element el = this.getElement(name);
            if (el != null) {
                el.setValue(values.get(key));
            }
        }
    }

    protected void initValues(HttpServletRequest request) {
        Enumeration<String> parameters = request.getParameterNames();
        while (parameters.hasMoreElements()) {
            String name = parameters.nextElement();

            Element element = this.getElement(name);
            if (element != null) {
                element.setValue(request.getParameter(name));
            }
        }
    }

    public void process(HttpServletRequest request) throws FormException {
        if (!Dispatcher.getInstance().getRequest().getMethod().equals("POST")) {
            return;
        }

        this.initValues(request);

        if (!this.isValid()) {
            return;
        }

        this.mainProcess();
    }

    abstract protected void mainProcess() throws FormException;

    public Element addElement(Element element) {
        this.elements.add(element);

        return element;
    }

    public Element getElement(String name) {
        for (Element e : this.elements) {
            if (e.getName().equals(name)) {
                return e;
            }
        }

        return null;
    }

    public String getValue(String name) {
        Element element = this.getElement(name);
        return element == null ? null : element.getValue();
    }

    public List<Element> getElements() {
        return this.elements;
    }

    protected Renderer createRenderer() {
        return new FormRenderer();
    }

}
