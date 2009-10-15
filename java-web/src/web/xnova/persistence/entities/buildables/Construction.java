package web.xnova.persistence.entities.buildables;

import java.util.List;
import web.xnova.persistence.entities.resources.*;

public abstract class Construction {

	private List<ConstructionProperty> properties;
    private List<ConstructDependency> dependencies;
    private String name;
    private List<ResourceAmount> cost;
    private long upgrade_starts_time;

    public int getLevel() { 
    	return (Integer) this.getProperty( ConstructionProperty.PROPERTY_LEVEL ).getValue(); 
    }
    
    public int getUpgradeTime() {
    	return (Integer) this.getProperty( ConstructionProperty.PROPERTY_UPGRADE_TIME ).getValue();
    }

    public List<ConstructDependency> getDependencies() {
    	return this.dependencies;
    }

    /**
     * @TODO Implements
     * @return
     */
    public Construction upgrade() {
    	// Implements
    	
    	return this;
    }
    
    
    public long getUpgradeLeftTime() {
    	return new java.util.Date().getTime() - this.upgrade_starts_time;
    }
    
    
    public boolean isReady() {
    	return this.getUpgradeLeftTime() > this.getUpgradeTime();
    }
    
    public Construction setProperty( String name, Object value ) {
    	this.getProperty( name ).setValue(value);
    	return this;
    }

    protected ConstructionProperty getProperty(String name) {
    	for ( ConstructionProperty p : this.properties ) {
    		if ( p.equals(name) ) {
    			return p;
    		}
    	}
    	
    	return null;
    }


}
