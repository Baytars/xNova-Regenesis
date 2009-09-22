package controllers;

import core.MapBuilder;
import core.Player;
import core.Map;
import flash.geom.Point;
import flash.net.URLLoader;
import flash.net.URLRequest;
import core.Registry;

class ApplicationController {
    
    static public function main() {
        var builder:MapBuilder = new MapBuilder();
		
		var loader:URLLoader = new URLLoader();        
        loader.addEventListener("complete", function(e:Dynamic) {
        	var map:Map = builder.buildFromXml(e.target.data);
        
			map.addListener("init", function() {
				Player.getInstance().attachToMap( map );
				
				Player.getInstance().addListener("move", function(e:core.events.player.Move) {
					ApplicationController.onPlayerMove( e.getStartPoint(), e.getEndPoint() );
				});
			});
			
            Main.getInstance().addChild( map.render() );
        });
        
        loader.load( new URLRequest( Registry.get("site_url") + '/maps/1.xml' ) );
    }
    
    public static function onPlayerMove( startPoint:Point, endPoint:Point ) {
		var current = flash.Lib.current;
		var player = Player.getInstance();
		
		var yOffset:Float = 0;
		var xOffset:Float = 0;
		
		var deltaX:Float = endPoint.x - startPoint.x;
		var deltaY:Float = endPoint.y - startPoint.y;
		
		if ( deltaY != 0 ) {
			if ( deltaY > 0 ) {
				yOffset -= player.getAccel();
			} else {
				yOffset += player.getAccel();
			}
		}
		
		if ( deltaX != 0 ) {
			if ( deltaX > 0 ) {
				xOffset -= player.getAccel();
			} else {
				xOffset += player.getAccel();
			}
		}
		
		current.x = current.x + xOffset;
		current.y = current.y + yOffset;
		
		return true;
	}
    
}
