package org.uinator;

import java.lang.reflect.*;
import java.util.*;
import org.uinator.readers.*;
import org.uinator.utils.*;
import org.uinator.reflection.*;

public class Unserializer {

    private ReflectionProvider _reflectionProvider;

    public Unserializer(ReflectionProvider _provider ) {
        this._reflectionProvider = _provider;
    }

    /**
     * Generate reflection of data node into context class
     * 
     * @param Class<T> context
     * @param Node contextNode
     * @return T
     * @throws UnserializerException
     */
    public Object process(Class context, Node contextNode) throws UnserializerException {
        try {
        	Object instance = this.getReflectionProvider().createInstance(context);
        	if ( instance == null ) {
        		throw new UnserializerException();
        	}
        	
        	
            for (Node attr : contextNode.getAttributes() ) {
            	this.processAttribute( instance, attr );
            }

            for (Node subElement : contextNode.getChilds() ) {
            	this.processChild( subElement, context, instance );
            }
            
            return instance;
        } catch (Exception e) {
        	e.printStackTrace();
        	throw new UnserializerException(e);
        }
    }
    
    protected void processChild( Node subElement, Class context, Object result ) throws UnserializerException {
		try {
            String targetPkg = "org.uinator";
        	
        	Namespace elNamespace = subElement.getRegisteredNamespace( subElement.getNamespace() );
            if ( elNamespace != null && !elNamespace.equals("") ){
            	targetPkg = elNamespace.getPath();
            }
            
            Class targetCls = null;
            try {
                String targetClsName = subElement.getName();
                targetCls = this.getReflectionProvider().findClass(targetClsName, targetPkg);
            } catch (ClassNotFoundException e) {
            	return;
            }

            Field[] clsFields = context.getDeclaredFields();
            for (int i = 0; i < clsFields.length; i++) {
                Class type = clsFields[i].getType();
                Field field = clsFields[i];

                if ( this.getReflectionProvider().isParent(AbstractCollection.class, type) ) {
                    type = this.getReflectionProvider().getClassForType((ParameterizedType) field.getGenericType());
                    Object newItem = this.process(type, subElement);

                    if ( this.getReflectionProvider().isParent(type, targetCls)) {
                        try {
                            this.getReflectionProvider().invokeMethod("add".concat(StringUtils.toCamelCase(field.getName(), "", StringCase.UPPER)), result, newItem);
                        } catch (Exception e) {
                            this.getReflectionProvider().invokeMethod("add", this.getReflectionProvider().initializeField(field, result), newItem);
                        }
                    }
                } else if (targetCls.getName().equals(field.getName() ) || type.getName().equals( targetCls.getName() ) ) {
                    Object fieldValue = this.process(type, subElement);
                    try {
                        this.getReflectionProvider().invokeMethod("set".concat(StringUtils.toCamelCase(field.getName(), "", StringCase.UPPER)), result, fieldValue);
                    } catch (Exception e) {
                		this.getReflectionProvider().setFieldValue(field.getName(), fieldValue, result );
                    }
                }
            }
    	} catch ( Exception e ) {
    		throw new UnserializerException(e);
    	}
    }
    
    protected void processAttribute( Object instance, Node attr ) {
        System.out.println("Property: " + attr.getName());
        String name = StringUtils.toCamelCase(attr.getName(), "_", StringCase.LOWER);

        try {
            this.getReflectionProvider().setFieldValue(name, this.processStringValue( (String)attr.getValue() ), instance);
        } catch (Exception e) {
        	e.printStackTrace();
        	try {
        		this.getReflectionProvider().invokeMethod( StringUtils.toCamelCase("set_".concat(name), "_", StringCase.UPPER ), instance, attr.getValue() );
        		System.out.println("Field " + name + " does not exists");
        	} catch ( Exception s ) {
        		s.printStackTrace();
        		System.out.println("Setter for field " + name + " does not exists");
        	}
        }
    }
    
    protected Object processStringValue( String value ) {
    	Object result = null;
    	
    	try {
    		result = Integer.parseInt(value);
    	} catch ( Exception e ) {
    		try {
    			result = Float.parseFloat(value);
    		} catch ( Exception e1 ) {
    			try {
    				result = Boolean.parseBoolean(value);
    			} catch ( Exception e2 ) {
    				result = value;
    			}
    		}
    	}
    	
    	return result;
    }

    protected ReflectionProvider getReflectionProvider() {
        return this._reflectionProvider;
    }

    protected void setReflectionProvider( ReflectionProvider provider ) {
        this._reflectionProvider = provider;
    }

}

class UnserializerException extends Exception {

    /**
	 * 
	 */
	private static final long serialVersionUID = -5253230702722468037L;

	public UnserializerException() {
		
	}
	
	public UnserializerException(Exception e) {
		this();
		
        this.setStackTrace(e.getStackTrace());
    }
}
