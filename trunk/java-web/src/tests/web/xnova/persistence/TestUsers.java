package tests.web.xnova.persistence;

import org.mvc.*;
import web.xnova.persistence.entities.*;
import web.xnova.persistence.managers.*;

import org.junit.*;
import static org.junit.Assert.*;

public class TestUsers {
	
	@Before public void setUp() {
		Main.start();
	}
	
	@Test public void testMain() throws Throwable {
		User u = (User) UserManager.getInstance().createUser("test", "test", "test@test.com");
		assertNotNull(u);
		assertEquals( "test", u.getLogin() );
		assertEquals( "test", u.getPassword() );
		assertEquals( "test@test.com", u.getEmail() );
		
		assertNotNull( UserManager.getInstance().findByCredentials("test", "test") );
	}

}
