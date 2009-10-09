package web.xnova.persistence.managers;

import org.hibernate.Session;
import org.mvc.Main;

import web.xnova.persistence.entities.*;

public class UserManager extends Manager<User> {
	
	private static final UserManager instance = new UserManager();
	
	public static UserManager getInstance() {
		return instance;
	}
	
	public User createUser(String login, String password, String email ) throws EntityException, ManagerException {
		try {
			if ( !this.isExists(login, email) ) {
			   User user = new User();
			   user.setLogin(login);
			   user.setPassword(password);
			   user.setEmail( email );
			   
			   this.save(user);
			   
			   return user;
			} else {
			   throw new EntityException("User with this login or email alredy exists");
		    }
		} catch ( Throwable e ) {
			throw new EntityException(e);
		}
	}
	
	public User findByCredentials( String login, String password ) throws ManagerException {
		try {
			Session session = this.openSession();
			
			User u = (User) session.createQuery("select user.* from users where login = ? and password = ?")
								  .setEntity( 0, login )
								  .setEntity( 1, password )
								  .uniqueResult();
			
			return u;
		} catch ( Throwable e ) {
			Main.error_log.error("Database error!!11", e);
			throw new ManagerException();
		}
	}
	
	protected boolean isExists( String login, String email ) throws ManagerException {
		try {
			Session session = this.openSession();
			
			User u = (User)session.createQuery("select user.id from users where login = ? or email = ?")
							.setEntity(0, login)
							.setEntity(1, email)
							.uniqueResult();
			
			if ( u != null ) {
				return true;
			}

			return false;
		} catch( Throwable e ) {
			throw new ManagerException();
		}
		
	}

}
