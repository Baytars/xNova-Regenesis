package org.uinator.readers.dom;

import org.uinator.readers.*;
import org.w3c.dom.NamedNodeMap;
import org.w3c.dom.Node;

public class DOMReader implements Reader {

    public org.uinator.readers.Node process(Source source) throws ReadException {
        return this.convertDOMTree((Node) source.getRawSource());
    }

    public org.uinator.readers.Node convertDOMTree(Node source) {
        org.uinator.readers.Node result = new org.uinator.readers.Node();

        NamedNodeMap attributes = source.getAttributes();
        if (attributes != null) {
            for (int nAttr = 0; nAttr < attributes.getLength(); nAttr++) {
                String nameParts[] = this.processNodeName( attributes.item(nAttr).getNodeName() );
                String nodeName = nameParts[1];
                String namespace = nameParts[0];

                if ( namespace != null && namespace.equals("xmlns") ) {
                    result.registerNamespace( new Namespace( nodeName, attributes.item(nAttr).getNodeValue() ) );
                } else {
                    result.addAttribute( nodeName, attributes.item(nAttr).getNodeValue(), namespace );
                }
            }
        }

        for (Node _child = source.getFirstChild(); _child != null; _child = _child.getNextSibling()) {
            result.addChild(this.convertDOMTree(_child));
        }

        result.setValue(source.getNodeValue()).setName(source.getNodeName());

        return result;
    }

    protected String[] processNodeName( String nodeName ) {
        String result[] = { nodeName, null };

        if ( nodeName.contains(":") ) {
            result[0] = nodeName.substring( 0, nodeName.indexOf(":") );
            result[1] = nodeName.substring( nodeName.indexOf(":") + 1 );
        }

        return result;
    }
}
