package org.uinator;

import java.io.*;

import javax.xml.parsers.*;
import org.w3c.dom.Document;
import org.xml.sax.SAXException;

import org.uinator.Unserializer;
import org.uinator.readers.dom.*;

public class Parser {

    private Unserializer _unserializer;

    public UI parse(File file) throws ParserException {
        try {
            Unserializer processor = new Unserializer( new org.uinator.reflection.BaseReflectionProvider() );
            
            return (UI) processor.process(UI.class, new org.uinator.readers.dom.DOMReader().process( 
        												new DOMNodeSource(this.getXmlDocument(file).getDocumentElement() 
            										) 
            							  ) );
        } catch (Exception e) {
            e.printStackTrace();
            throw new ParserException(e);
        }
    }

    protected Document getXmlDocument(File file) throws IOException, SAXException, ParserConfigurationException {
        return DocumentBuilderFactory.newInstance().newDocumentBuilder().parse(file);
    }
}

class ParserException extends Exception {

    /**
	 * 
	 */
	private static final long serialVersionUID = -3986689428368743565L;

	public ParserException(Exception e) {
        this.setStackTrace(e.getStackTrace());
    }
}
