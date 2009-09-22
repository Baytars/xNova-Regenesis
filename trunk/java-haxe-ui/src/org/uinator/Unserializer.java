package org.uinator;

import java.lang.reflect.*;
import java.util.*;
import org.uinator.readers.*;
import org.uinator.utils.*;
import org.uinator.reflection.*;

public class Unserializer {

    private Reader _reader;
    private Node _source;
    private ReflectionProvider _reflectionProvider;

    public Unserializer(Reader reader, ReflectionProvider _provider ) {
        this._reader = reader;
        this._reflectionProvider = _provider;
    }

    public void setSource(Source source) throws ReadException {
        this._source = this.getReader().process(source);
    }

    public Node getSource() {
        return this._source;
    }

    public Unserializer setReader(Reader reader) {
        this._reader = reader;
        return this;
    }

    public Reader getReader() {
        return this._reader;
    }

    public Object process(Class context, Node contextNode) throws UnserializerException {
        try {
            if (contextNode == null) {
                contextNode = this._source;
            }

            Object result = context.newInstance();
            ArrayList<Node> attrs = contextNode.getAttributes();
            for (Node attr : attrs) {
                System.out.println("Process attributes list");
                System.out.println("Property: " + attr.getName());
                String name = StringUtils.toCamelCase(attr.getName(), "_", StringCase.LOWER);

                try {
                    this.getReflectionProvider().setFieldValue(name, attr.getValue(), result);
                } catch (Exception e) {
                    System.out.println("Field " + name + " does not exists");
                }
            }

            for (Node subElement : contextNode.getChilds()) {
                String targetPkg = null;//subElement.getNamespaceURI() != null ? subElement.getNamespaceURI() : Unserializer.class.getPackage().getName();
                Class targetCls = null;
                try {
                    String targetClsName = subElement.getName().contains(":") ? subElement.getName().split(":")[1]
                            : subElement.getName().split(":")[0];
                    targetCls = this.getReflectionProvider().findClass(targetClsName, targetPkg);
                } catch (ClassNotFoundException e) {
                    continue;
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
                            this.getReflectionProvider().setFieldValue(field.getName(), result, fieldValue);
                        }
                    }
                }
            }

            return result;
        } catch (Exception e) {
            throw new UnserializerException(e);
        }
    }

    protected ReflectionProvider getReflectionProvider() {
        return this._reflectionProvider;
    }

    protected void setReflectionProvider( ReflectionProvider provider ) {
        this._reflectionProvider = provider;
    }

}

class UnserializerException extends Exception {

    public UnserializerException(Exception e) {
        this.setStackTrace(e.getStackTrace());
    }
}
