package controllers;

import core.Registry;
import core.Player;
import flash.geom.Point;

class PhysicsController {
	
	public static function init() {
		bindPlayer( Player.getInstance() );
	}
	
	public static function bindPlayer( player:Player ) {
		player.addListener("beforemove", function(e:core.events.player.Move) {
			var map = Player.getInstance().getCurrentMap();
			var endPoint = e.getEndPoint();
			
			//if ( map.getCollisions( endPoint ).length == 0 ) {
				//return true;
			//}
			
			return true;
		});
	}
	
	public static function bindBullet( bullet:core.Bullet ) : Void {
		bullet.addEventListener("enterFrame", function( e:flash.events.Event ) : Void {
			var objects:List<core.MapObject> = Registry.get("current_map").getCollisions( e.target.getPoint() );
			
			for ( object in objects ) {
				// object.takeDamage( bullet.getDamageType() );
			}
		});
		
		bullet.addEventListener("enterFrame", function( e:flash.events.Event ) : Void {
			//~ trace('dsadas');
			//~ if ( bullet.getX() > Registry.get("current_map").getWidth() ) {
				//~ //bullet_mc.parent.removeChild( bullet_mc );
			//~ } else {
				bullet.setX( bullet.getX() + 5 );
			//~ }
		});
	}
}
