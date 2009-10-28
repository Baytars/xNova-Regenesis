package web.xnova.persistence.managers;

import org.mvc.Main;

import web.xnova.persistence.entities.*;
import web.xnova.persistence.entities.EntityException;
import web.xnova.persistence.entities.Galaxy;

import org.apache.log4j.*;

public class GalaxiesManager extends Manager {
	
	private static final Logger log = Logger.getLogger( web.xnova.persistence.managers.GalaxiesManager.class );
	private static final GalaxiesManager instance = new GalaxiesManager();
	
	public static GalaxiesManager getInstance() {
		return instance;
	}
	
	public Galaxy createGalaxy( String name ) throws EntityException, ManagerException {
		Galaxy galaxy = new Galaxy();
		galaxy.setName(name);
		
		try {
			this.save(galaxy);
		} catch ( Throwable e ) {
			log.error(e.getMessage(), e );
			throw new ManagerException();
		}
		
		return galaxy;
	}
	
}
