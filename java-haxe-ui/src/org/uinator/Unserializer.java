package org.uinator;

import java.lang.reflect.*;
import java.util.*;
import org.uinator.readers.*;
import org.uinator.utils.*;

public class Unserializer {	

	private Reader _reader;
	private Node _source;
	
	public Unserializer( Source source, Reader reader ) throws ReadException {
		this._reader = reader;
		this._source = reader.process(source);
	}
	
	public Unserializer setReader( Reader reader ) {
		this._reader = reader;
		return this;
	}
	
	public Reader getReader() {
		return this._reader;
	}
	
	public Object process( Class context, Node contextNode ) throws UnserializerException
    {
		try {
			if ( contextNode == null ) {
				contextNode = this._source;
			}
			
			Object result = context.newInstance();
			ArrayList<Node> attrs = contextNode.getAttributes();
			for ( Node attr:attrs ) {
				System.out.println("Process attriubutes list");
				System.out.println("Property: " + attr.getName() );
				String name = StringUtils.toCamelCase( attr.getName(), "_", StringCase.LOWER );
				
				try {
					setFieldValue(name, attr.getValue(), result);
				} catch ( Exception e ) {
					System.out.println("Field " + name + " does not exists");
				}
			}
				
			for ( Node subElement:contextNode.getChilds() ) {
				String targetPkg = null;//subElement.getNamespaceURI() != null ? subElement.getNamespaceURI() : Unserializer.class.getPackage().getName();
				Class targetCls = null;
				try {
					String targetClsName = subElement.getName().contains(":") ? subElement.getName().split(":")[1] 
					                  					                          : subElement.getName().split(":")[0];
					targetCls = findClass( targetClsName, targetPkg );
				} catch ( ClassNotFoundException e ) {
					continue;
				}
				
				Field [] clsFields = context.getDeclaredFields();
				for ( int i = 0; i < clsFields.length; i++ ) {
					Class type = clsFields[i].getType();
					Field field = clsFields[i];	
					
					if ( isParent( AbstractCollection.class, type ) ) {
						type = getClassForType( (ParameterizedType) field.getGenericType() );
						Object newItem = this.process( type, subElement );
						
						if ( isParent( type, targetCls) ) {
							try {
								invokeMethod( "add".concat( StringUtils.toCamelCase( field.getName(), "", StringCase.UPPER ) ), result,  newItem );
							} catch ( Exception e ) {
								invokeMethod("add", initializeField( field, result ), newItem );
							}
						}
					} else if ( targetCls.getName() == field.getName() || type.getName() == targetCls.getName() ) {
						Object fieldValue = this.process( type, subElement );
						try {
							invokeMethod( "set".concat( StringUtils.toCamelCase( field.getName(), "", StringCase.UPPER ) ), result, fieldValue );
						} catch ( Exception e ) {
							setFieldValue( field.getName(), result, fieldValue  );
						}
					}
				}
			}
	
			return result;
		} catch ( Exception e ) {
			throw new UnserializerException(e);
		}
	}
	
	protected Class findClass( String name, String clsPackage ) throws ClassNotFoundException {
		String path = StringUtils.toCamelCase( name, "", StringCase.UPPER );
		if ( clsPackage != null ) {
			path = clsPackage + '.' + path;
		}
		
		Class currClass = Class.forName( path );
		
		return currClass;
	}
	
	protected void invokeMethod( String name, Object context, Object... args ) throws NoSuchMethodException, InvocationTargetException, IllegalAccessException 
	{
		Class cls = context.getClass();
		
		ArrayList<Class> argsClasses = new ArrayList<Class>();
		for( Object arg:args ) {
			argsClasses.add( arg.getClass() );
		}
		
		for( Method method:cls.getDeclaredMethods() ) {
			if ( method.getName() == name && checkMethodParameters( method, argsClasses ) ) {
				method.invoke( context, args );
				return;
			}
		}
		
		throw new NoSuchMethodException();
	}
	
	protected String getActualParameterType( ParameterizedType type ) {
		return type.getActualTypeArguments()[0].toString().replace("class ", "");
	}
	
	protected boolean checkMethodParameters( Method method, List<Class> classes ) {
		boolean result = false;
		
		int equalsCount = 0;
		for( Class parameterClass: method.getParameterTypes() ) {
			for ( Class cls:classes ) {
				if ( isParent(parameterClass, cls) || cls.getName() == parameterClass.getName() ) {
					equalsCount++;
					break;
				}
			}
		}
		
		if ( equalsCount == method.getParameterTypes().length ) {
			result = true;
		}
		
		return result;
	}
	
	protected boolean isParent( Class parent, Class child ) {
		Class pParent = parent;
		Class cParent = child;
		while ( pParent != cParent && pParent != null && cParent != null ) {
			// Чтобы если parent - конечный предок, метод возвращал правильный результат
			pParent = pParent.getSuperclass() != null ? pParent.getSuperclass() : pParent;
			cParent = cParent.getSuperclass();
		}
		
		return pParent == cParent;
	}
	
	protected void setFieldValue( String name, Object value, Object context ) throws NoSuchFieldException, IllegalAccessException {
		System.out.println("Setting value to field " + name + " in " + value);
		try {
			// First look for user
			invokeMethod( "set" + StringUtils.toCamelCase( name, "", StringCase.UPPER ), context, value);
		} catch ( Exception e ) {
			Field field = context.getClass().getDeclaredField(name);
			
			System.out.println("Setting value of field " + field.getName() + " to " + value );
			field.set( context, value );
		}
	}
	
	protected Class getClassForType( ParameterizedType type ) {
		Type actualType = type.getActualTypeArguments()[0];
		// Huk to get actual name of generic type class
		String actualClassName = actualType.toString().replace("class ", "");
		
		Class result = null;
		try {
			result = Class.forName(actualClassName);
		} catch ( ClassNotFoundException e ) {
			// not need in exception handling 
		}
		
		return result;
	}
	
	protected Object initializeField( Field field, Object context ) throws IllegalAccessException, InstantiationException, NoSuchFieldException{
		Object value = field.get(context);
		if ( value == null ) {
			try {
				invokeMethod( "initialize" + StringUtils.toCamelCase( field.getName(), "", StringCase.UPPER ), context );
			} catch ( Exception e ) {
				value = field.getType().newInstance();
				field.set(context, value);
			}
		}
		
		return value;
	}
	
}

class UnserializerException extends Exception {

	public UnserializerException(Exception e) {
		this.setStackTrace(e.getStackTrace());
	}
	
}
