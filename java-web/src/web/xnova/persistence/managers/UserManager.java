package web.xnova.persistence.managers;

import org.hibernate.Session;
import org.mvc.Main;

import web.xnova.persistence.entities.*;
import web.xnova.persistence.entities.EntityException;
import web.xnova.persistence.entities.User;

import org.apache.log4j.*;

public class UserManager extends Manager {
	
	private static Logger log = Logger.getLogger( web.xnova.persistence.managers.UserManager.class );
	private static final UserManager instance = new UserManager();
	
	public static UserManager getInstance() {
		return instance;
	}
	
	public User createUser(String login, String password, String email ) throws EntityException, ManagerException {
		if ( !this.isExists(login, email) ) {
		   User user = new User();
		   user.setLogin(login);
		   user.setPassword(password);
		   user.setEmail( email );
		   
		   try {
			   this.save(user);
		   } catch ( Throwable e ) {
			   throw new ManagerException();
		   }
		   
		   return user;
		} else {
		   throw new EntityException("User with this login or email alredy exists");
	    }
	}
	
	public User findByCredentials( String login, String password ) throws ManagerException {
		try {
			Session session = this.openSession();
			
			User u = (User) session.createQuery("from User as user" +
					"							where user.login = :login and " +
					"								  user.password = :password")
								  .setString( "login", login )
								  .setString( "password", password )
								  .uniqueResult();
			
			return u;
		} catch ( Throwable e ) {
			log.error( e.getMessage(), e );
			throw new ManagerException();
		}
	}
	
	protected boolean isExists( String login, String email ) throws ManagerException {
		try {
			Session session = this.openSession();
			
			Integer id = (Integer) session.createQuery("select user.id " +
					"							from User as user" +
					"							where user.login = :login or" +
					"								  user.email = :email")
							.setString("login", login)
							.setString("email", email)
							.uniqueResult();
			
			if ( id != null ) {
				return true;
			}

			return false;
		} catch( Throwable e ) {
			log.error(e.getMessage(),e);
			throw new ManagerException();
		}
		
	}

}
