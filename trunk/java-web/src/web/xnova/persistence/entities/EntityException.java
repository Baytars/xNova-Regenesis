package web.xnova.persistence.entities;

public class EntityException extends Exception {
	
	public EntityException( String message ) {
		super(message);
	}
	
	public EntityException( Throwable e ) {
		this.initCause(e);
	}
}
