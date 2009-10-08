package org.mvc.form;

import javax.servlet.http.*;

import java.util.Enumeration;
import java.util.List;
import java.util.ArrayList;
import java.util.Map;

import org.mvc.form.renderers.*;
import org.mvc.form.validators.*;
import org.mvc.http.*;


abstract public class Form extends Element  {
	
	private List<Element> elements;
	private String action;
	private String method;
	
	public Form() {
		this.elements = new ArrayList<Element>();
		
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
	
	public boolean isValid() {
		boolean result = true;
		for ( Element el : this.getElements() ) {
			if ( !el.isValid() ) {
				result = false;
				break;
			}
		}
		
		return result;
	}
	
	protected void initValues( Map<String, String> values ) {
		for ( Object key : values.keySet().toArray() ) {
			String name = (String) key;
			
			Element el = this.getElement(name);
			if ( el != null ) {
				el.setValue( values.get(key) );
			}
		}
	}
	
	protected void initValues( HttpServletRequest request ) {
		Enumeration<String> parameters = request.getParameterNames();
		while( parameters.hasMoreElements() ) {
			String name = parameters.nextElement();
			
			Element element = this.getElement(name);
			if ( element != null ) {
				element.setValue( request.getParameter(name) );
			}
		}
	}
	
	public void process( HttpServletRequest request ) throws FormException {
		this.initValues(request);
		
		if ( !this.isValid() ) {
			throw new FormException("not valid input");
		} 
		
		this.mainProcess();
	}
	
	abstract protected void mainProcess() throws FormException;
	
	public Element addElement( Element element ) throws FormException {
		if ( element.getName() == null ) {
			throw new FormException("Element must have name");
		}
		
		this.elements.add( element );
		
		return element;
	}
	
	public Element getElement( String name ) {
		for ( Element e : this.elements ) {
			if ( e.getName() == name ) {
				return e;
			}
		}
		
		return null;
	}
	
	public List<Element> getElements() {
		return this.elements;
	}
	
	protected Renderer createRenderer() {
		return new FormRenderer();
	}
	
}
