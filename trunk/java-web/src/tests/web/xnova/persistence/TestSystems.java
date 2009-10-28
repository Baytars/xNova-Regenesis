package tests.web.xnova.persistence;

import static org.junit.Assert.*;
import org.junit.*;
import org.mvc.Main;

import web.xnova.persistence.entities.Galaxy;
import web.xnova.persistence.entities.systems.*;
import web.xnova.persistence.entities.systems.System;
import web.xnova.persistence.managers.GalaxiesManager;
import web.xnova.persistence.managers.SystemsManager;

public class TestSystems {

	@Before public void setUp() {
		Main.start();
	}
	
	@Test public void main() throws Exception {
		Galaxy g = GalaxiesManager.getInstance().createGalaxy("g1");
		assertNotNull( g );
		assertEquals("g1", g.getName() );
		
		DarkSystem s = (DarkSystem) SystemsManager.getInstance().createSystem( DarkSystem.class, "s2", g );
		assertNotNull( s );
		assertEquals( "s2", s.getName() );
	}
	
}
