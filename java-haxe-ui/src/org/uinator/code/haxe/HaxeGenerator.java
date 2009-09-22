package org.uinator.code.haxe;

import java.util.HashMap;
import org.uinator.utils.*;
import org.uinator.*;
import org.uinator.code.*;

public class HaxeGenerator {
	
	private int _nextId = 0;
	private HashMap<Integer, String> _namesIndex;
	
	public HaxeGenerator() {
		this._namesIndex = new HashMap<Integer, String>();
	}
	
	public int getNextId() {
		this._nextId += 1;
		return this._nextId;
	}
	
	public String process( UI object ) throws GeneratorException {
		Package mainPkg = new Package("");
		Class mainCls = mainPkg.addClass( new Class("Main", "MovieClip", null ) );
		
		for ( org.uinator.Import imp:object.getImports() ) {
			mainPkg.addImport( new Import( imp.getPath() ) );
		}
		
		Method entryPointMethod = mainCls.addMethod( new Method("main", Class.ACCESS_PUBLIC, "void", true) );
		Variable mainClsContext = (Variable) entryPointMethod.addStatement( new Variable("main", "Main", "getInstance()") );
		
		Method initMethod = mainCls.addMethod( new Method("init", Class.ACCESS_PRIVATE, "void", false ) );
		this.processWidget(object, initMethod.getStatementsBlock() );
		
		entryPointMethod.addStatement( new MethodInvoke(mainClsContext, "init", null) );
		
		return mainPkg.getPrinter().render();
	}
	
	protected Variable getObjectInstance( Object v ) {
		return new Variable( this.getVariableName(v), this.getClassName( v ), "new ".concat( this.getClassName( v ) ).concat("()") );
	}
	
	protected String getClassName( Object v ) {
		String name = v.getClass().getName();
		String [] nameParts = name.split("\\.");
		if ( nameParts.length > 0 ) {
			name = nameParts[nameParts.length-1];
		}
		
		return name;
	}
	
	protected String getVariableName( Object v ) {
		if ( !this._namesIndex.containsKey( v.hashCode() ) ){
			String name = StringUtils.toCamelCase(this.getClassName(v), "_", StringCase.LOWER );
			
			this._namesIndex.put( v.hashCode(), name.concat( String.valueOf( this.getNextId() ) ) );
		}
		
		return this._namesIndex.get( v.hashCode() );
	}
	
	protected void processWidget( Widget w, Block context ) {
		Variable v = (Variable) context.addStatement( this.getObjectInstance( w ) );
		for ( Widget wC:w.getWidgets() ) {
			this.processWidget( wC, context );
			
			context.addStatement( new MethodInvoke( v, "addWidget", this.getObjectInstance(wC) ) );
		}	
		
		if ( w.getLayout() != null ) {
			context.addStatement( new MethodInvoke( v, "setLayout", this.getObjectInstance( w.getLayout() ) ) );
		}
	}
	
	
}

