package web.xnova.persistence.entities;


abstract public class PropertyValue {

    private Property base_property;
    private Object value;


    public Property getBaseProperty() {
        return this.base_property;
    }

    public PropertyValue setBaseProperty(Property property) {
        this.base_property = property;
        return this;
    }

    public final String getName() {
        return this.base_property.getName();
    }

    public PropertyValue setValue(Object value) {
        this.value = value;
        return this;
    }

    public Object getValue() {
        return this.value;
    }


}
