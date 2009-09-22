package org.uinator.readers.dom;

import org.uinator.readers.ReadException;
import org.uinator.readers.Reader;
import org.uinator.readers.Source;
import org.w3c.dom.NamedNodeMap;
import org.w3c.dom.Node;

public class DOMReader implements Reader {
	
	public org.uinator.readers.Node process( Source source ) throws ReadException {
		return this.convertDOMTree( (Node)source.getRawSource() );
	}
	
	public org.uinator.readers.Node convertDOMTree( Node source ) {
		org.uinator.readers.Node result = new org.uinator.readers.Node();
		
		NamedNodeMap attributes = source.getAttributes();
		if ( attributes != null ) {
			for( int nAttr = 0; nAttr < attributes.getLength(); nAttr++ ) {
				result.addAttribute( attributes.item(nAttr).getNodeName(), attributes.item(nAttr).getNodeValue() );
			}
		}
		
		for ( Node _child = source.getFirstChild(); _child != null; _child = _child.getNextSibling() ) {
			result.addChild( this.convertDOMTree(_child) );
		}
		
		result.setValue( source.getNodeValue() )
		  	  .setName( source.getNodeName() );
		
		return result;
	}

}
