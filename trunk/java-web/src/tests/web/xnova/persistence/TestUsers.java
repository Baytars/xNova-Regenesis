package tests.web.xnova.persistence;

import org.junit.*;
import static org.junit.Assert.*;
import org.mvc.Main;
import web.xnova.persistence.entities.User;
import web.xnova.persistence.managers.UserManager;

public class TestUsers {

    @Before
    public void setUp() {
        Main.start();
    }

    @Test
    public void testMain() throws Throwable {
        User u = (User) UserManager.getInstance().createUser("test", "test", "test@test.com");
        assertNotNull(u);
        assertEquals("test", u.getLogin());
        assertEquals("test", u.getPassword());
        assertEquals("test@test.com", u.getEmail());

        assertNotNull(UserManager.getInstance().findByCredentials("test", "test"));
    }

}
