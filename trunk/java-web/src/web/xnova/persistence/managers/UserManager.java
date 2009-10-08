package web.xnova.persistence.managers;

import org.hibernate.Session;
import org.mvc.*;

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
	
	public boolean isExists( String login, String email ) throws ManagerException {
		try {
			Session session = this.getSession();
			session.beginTransaction();
			
			User u = (User)session.createQuery("select user.id from users where user.login = ? or user.email = ?")
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
