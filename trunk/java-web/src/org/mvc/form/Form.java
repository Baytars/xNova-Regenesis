package org.mvc.form;

import java.util.List;
import java.util.Map;
import java.util.HashMap;

import org.mvc.form.renderers.*;

abstract public class Form extends Element  {
	
	private Map<String, Element> elements;
	private String action;
	private String method;
	
	public Form() {
		this.elements = new HashMap<String, Element>();
		
		this.removeDecorators();
	}
	
	public void setAction( String action ) {
		this.action = action;
	}
	
	public String getAction() {
		return this.action;
	}
	
	public String getMethod() {
		return this.method;
	}
	
	public void setMethod( String method ) {
		this.method = method;
	}
	
	abstract public Result process();
	
	public Element addElement( Element element ) throws FormException {
		if ( element.getName() == null ) {
			throw new FormException("Element must have name");
		}
		
		this.elements.put( element.getName(), element);
		
		return element;
	}
	
	public Element getElement( String name ) {
		return this.elements.get(name);
	}
	
	public Map<String, Element> getElements() {
		return this.elements;
	}
	
	protected Renderer createRenderer() {
		return new FormRenderer();
	}
	
}
