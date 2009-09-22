package org.uinator;

import java.io.File;

import java.io.IOException;

import javax.xml.parsers.DocumentBuilder;
import javax.xml.parsers.DocumentBuilderFactory;
import javax.xml.parsers.ParserConfigurationException;

import org.w3c.dom.Document;
import org.xml.sax.SAXException;

import org.uinator.Unserializer;
import org.uinator.readers.*;
import org.uinator.readers.dom.*;

public class Parser{

	private Unserializer _unserializer;
	
	public UI parse( File file ) throws ParserException {
		try {
			Unserializer processor = new Unserializer( new DOMNodeSource( this.getXmlDocument(file).getDocumentElement() ), new org.uinator.readers.dom.DOMReader() );
			
			return (UI)processor.process( UI.class, null );
		} catch ( Exception e ) {
			e.printStackTrace();
			throw new ParserException(e);
		}
	}
	
	
	protected Document getXmlDocument( File file ) throws IOException, SAXException, ParserConfigurationException {
		return DocumentBuilderFactory.newInstance()
									 	.newDocumentBuilder()
									 		.parse( file );
	}
	
}

class ParserException extends Exception {
	
	public ParserException( Exception e ) {
		this.setStackTrace( e.getStackTrace() );
	}
}
