package org.mvc.form;

import java.util.List;
import java.util.ArrayList;
import java.util.Map;
import java.util.HashMap;

import org.mvc.form.decorators.*;
import org.mvc.form.renderers.*;
import org.mvc.form.validators.Validator;


abstract public class Element {
	public static final String ATTR_LABEL = "label";
	
	private Renderer renderer;
	private String renderResult;
	
	protected String type;
	protected String name;
	protected String value;
	protected List<Validator> validators;
	protected List<Decorator> decorators;
	protected List<Element> pathMap;
	protected Map<String, Object> attributes;
	
	public Element() {
		this.validators = new ArrayList<Validator>();
		this.decorators = new ArrayList<Decorator>();
		this.pathMap = new ArrayList<Element>();
		this.attributes = new HashMap<String, Object>();
		
		this.addDecorator( new FormElement() );
	}
	
	public String getType() {
		return this.type;
	}
	
	public void setName( String name ) {
		this.name = name;
	}
	
	public String getName() {
		return this.name;
	}
	
	public void setBelongsTo( Element el ) {
		this.pathMap.add( el );
	}
	
	public String getBelongsTo() {
		String path = new String();
		for ( Element el : this.pathMap ) {
			if ( this.pathMap.indexOf(el) == 0 ) {
				path = path.concat( el.getName() );
			} else {
				path = path.concat( "[".concat( path.concat( el.getName() + "[") ) ); 
			}
		}
		
		return path;
	}
	
	public Element setValue( String value ) {
		this.value = value;
		return this;
	}
	
	public String getValue() {
		return this.value;
	}
	
	public boolean isValid() {
		for ( Validator v : this.validators ) {
			if ( !v.validate( this.getValue() ) ) {
				return false;
			}
		}
		
		return true;
	}
	
	public Element addValidator( Validator validator ) {
		this.validators.add(validator);
		return this;
	}
	
	public Element addDecorator( Decorator decorator ) {
		this.decorators.add(decorator);
		return this;
	}
	
	public List<Decorator> getDecorators() {
		return this.decorators;
	}
	
	public Element removeDecorators() {
		this.decorators.removeAll(this.decorators);
		return this;
	}
	
	public Element removeDecorator( Decorator d ) {
		this.decorators.remove(d);
		return this;
	}
	
	public List<Validator> getValidators() {
		return this.validators;
	}
	
	public Element setAttribute( String name, Object value ) {
		this.attributes.put(name, value);
		return this;
	}
	
	public Map<String, Object> getAttributes() {
		return this.attributes;
	}
	
	public Object getAttribute( String name ) {
		return this.attributes.get(name);
	}
	
	abstract protected Renderer createRenderer();
	
	protected Renderer getRenderer() {
		if ( null == this.renderer ) {
			this.renderer = this.createRenderer();
		}
		
		return this.renderer;
	}
	
	public Element setRenderer( Renderer r ) {
		this.renderer = r;
		return this;
	}
	
	public String getRendered() {
		if ( this.renderResult == null ) {
			this.renderResult = this._render();
		}
		
		return this.renderResult;
	}
	
	private String _render() {
		return this.getRenderer().render(this);
	}
	
	public String render() {
		String result = new String();
		
		if ( !this.getDecorators().isEmpty() ) {
			for ( Decorator d : this.getDecorators() ) {
				result = result.concat( d.decorate(this) );
			}
		} else {
			result = this.getRendered();
		}
		
		return result;
	}
}
