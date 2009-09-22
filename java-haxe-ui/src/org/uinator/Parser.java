package org.uinator;

import java.io.*;

import javax.xml.parsers.*;
import org.w3c.dom.Document;
import org.xml.sax.SAXException;

import org.uinator.Unserializer;
import org.uinator.readers.*;
import org.uinator.readers.dom.*;

public class Parser {

    private Unserializer _unserializer;

    public UI parse(File file) throws ParserException {
        try {
            Unserializer processor = new Unserializer(new org.uinator.readers.dom.DOMReader(), new org.uinator.reflection.BaseReflectionProvider() );
            processor.setSource(new DOMNodeSource(this.getXmlDocument(file).getDocumentElement()));
            return (UI) processor.process(UI.class, null);
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

    public ParserException(Exception e) {
        this.setStackTrace(e.getStackTrace());
    }
}
