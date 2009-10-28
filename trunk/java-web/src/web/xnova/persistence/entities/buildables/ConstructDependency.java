package web.xnova.persistence.entities.buildables;

import web.xnova.persistence.entities.*;
import web.xnova.persistence.entities.PropertyValue;

import java.util.List;

public class ConstructDependency {

    private Construction subject;
    private Construction object;
    
    /**
     * Properties values which entity under subject reference must match
     * @var List<PropertyValue>
     * @access private
     */
    private List<PropertyValue> subject_constrains;
    
    /**
     * Subject which dependency holder must contains ( includes it's constrains )
     * to resolve current dependency
     * 
     * @return Construction
     */
    public Construction getSubject() {
    	return this.subject;
    }
    
    /**
     * Object which dependence on subject of current dependencies
     * @return Construction
     */
    public Construction getObject() {
    	return this.object;
    }
    
    public List<PropertyValue> getSubjectConstrains() {
    	return this.subject_constrains;
    }

}
