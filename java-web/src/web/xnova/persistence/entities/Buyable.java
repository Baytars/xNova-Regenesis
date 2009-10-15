package web.xnova.persistence.entities;

import java.util.List;
import web.xnova.persistence.entities.resources.*;

public interface Buyable {
	
    public List<ResourceAmount> getCost();

}
