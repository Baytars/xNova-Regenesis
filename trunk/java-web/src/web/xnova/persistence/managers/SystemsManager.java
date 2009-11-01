package web.xnova.persistence.managers;

import org.apache.log4j.*;
import web.xnova.persistence.entities.EntityException;
import web.xnova.persistence.entities.Galaxy;
import web.xnova.persistence.entities.systems.System;

public class SystemsManager extends Manager {

    private static final SystemsManager instance = new SystemsManager();
    private static final Logger log = Logger.getLogger(web.xnova.persistence.managers.SystemsManager.class);

    public static SystemsManager getInstance() {
        return instance;
    }

    public System createSystem(Class<? extends System> system, String name, Galaxy galaxy) throws EntityException, ManagerException {
        System s = null;
        try {
            s = system.newInstance();
        } catch (Throwable e) {
            throw new EntityException(e);
        }

        s.setGalaxy(galaxy);
        s.setName(name);

        try {
            this.save(s);
            this.update(galaxy);
        } catch (Throwable t) {
            log.error(t.getMessage(), t);
            throw new ManagerException();
        }

        return s;
    }
}
