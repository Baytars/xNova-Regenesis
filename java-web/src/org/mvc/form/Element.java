package org.mvc.form;

import java.util.Comparator;
import java.util.List;
import java.util.ArrayList;
import java.util.Map;
import java.util.HashMap;
import java.util.Arrays;

import org.mvc.form.decorators.*;
import org.mvc.form.renderers.*;
import org.mvc.validators.Validator;


abstract public class Element {
	public static final String ATTR_LABEL	 = "label";
	public static final String ATTR_ID 		 = "id";
	
	protected String type;
	protected String name;
	protected String value;
	
	private boolean is_error;
	private List<String> errors;
	private Renderer renderer;
	private String renderResult;	
	private List<Validator> validators;
	private List<Decorator> decorators;
	private List<Element> pathMap;
	private Map<String, Object> attributes;
	
	public Element() {
		this.validators = new ArrayList<Validator>();
		this.decorators = new ArrayList<Decorator>();
		this.pathMap = new ArrayList<Element>();
		this.attributes = new HashMap<String, Object>();
		this.errors = new ArrayList<String>();
		
		this.addDecorator( new FormElement() );
	}
	
	public Element markAsError() {
		this.is_error = true;
		return this;
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
				this.markAsError();
				this.errors.add( v.getMessage() );
				
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
		if ( -1 == this.decorators.indexOf(decorator) ) {
			this.decorators.add(decorator);
		}
		
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
	
	public Element addError( String error ) {
		this.errors.add(error);
		
		this.is_error = true;
		
		return this;
	}
	
	public List<String> getErrors() {
		return this.errors;
	}
	
	public String render() {
		String result = new String();
		
		if ( this.is_error ) {
			this.addDecorator( new ErrorWrapper() );
		}
		
		if ( !this.getDecorators().isEmpty() ) {
			Decorator [] decorators =  this.getDecorators().toArray( new Decorator[this.getDecorators().size()] );
			// sort decorators by order ( which must be applied first, and which must be applied last )
			Arrays.sort( decorators, AbstractDecorator.getOrderSorter() );
			
			for ( Decorator d : decorators ) {
				result = result.concat( d.decorate(this) );
			}
		} else {
			result = this.getRendered();
		}
		
		return result;
	}
	
	public String getId() {
		String id = (String) this.getAttribute( Element.ATTR_ID );
		if ( null ==  id ) {
			id = this.getName();
		}
		
		return id;
	}
}
