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
        return this.renderDefinition();
    }
    
    public String renderDefinition() throws GeneratorException {
        Variable context = (Variable) this.getContext();

        String result = new String();
        result = result.concat(this.getAlignment())
                       .concat("var ")
                       .concat( context.getName() );

        if (context.getType() != null) {
            result = result.concat(":")
                           .concat(context.getType());
        }

        if (context.getValue() != null) {
            result = result.concat(" = ")
                           .concat(context.getValue());
        }

        result = result.concat(";")
                       .concat( Printer.NEW_LINE_CHARACTER );

        return result;
    }

    public String renderReference() throws GeneratorException {
        Variable context = (Variable) this.getContext();
        if ( context.getName() == null ) {
            throw new GeneratorException();
        }

        String result = new String();
        result = result.concat( context.getName() );

        return result;
    }

    public String renderInstance() throws GeneratorException {
        Variable context = (Variable) this.getContext();
        if ( context.getName() == null ) {
            throw new GeneratorException();
        }

        String result = new String();

        if ( context.getConstructionArgs() != null ) {
            result = result.concat( "new" )
                           .concat( context.getName() )
                           .concat( "(" );
            for ( Variable arg:context.getConstructionArgs() ) {
                result = result.concat( arg.getName() )
                               .concat(",");
            }
            result = result.concat(")");
        }

        return result;
    }
}
