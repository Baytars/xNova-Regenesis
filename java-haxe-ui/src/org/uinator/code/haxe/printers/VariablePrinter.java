package org.uinator.code.haxe.printers;

import org.uinator.code.*;
import org.uinator.code.GeneratorException;
import org.uinator.code.haxe.Variable;

public class VariablePrinter extends Printer {

	public VariablePrinter(Statement context) {
		super(context);
	}

	@Override
	public String render() throws GeneratorException {
		String result = new String();
		Variable context = (Variable) this.getContext();
		
		if ( context.getName() == null ) {
			throw new GeneratorException();
		}
		
		result = result.concat( this.getAlignment() ).concat( "var " ).concat( context.getName() );
		if ( context.getType() != null ) {
			result = result.concat( ":" ).concat( context.getType() );
		}
		
		if ( context.getValue() != null ) {
			result = result.concat(" = ").concat( context.getValue() );
		}
		
		result = result.concat(";").concat( String.valueOf( Printer.NEW_LINE_CHARACTER ) );
		
		return result;
	}
	
}
