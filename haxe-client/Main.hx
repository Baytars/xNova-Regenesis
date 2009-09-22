package;

import controllers.ApplicationController;
import core.Player;
import core.Registry;
import flash.display.MovieClip;
import controllers.PhysicsController;

class Main extends MovieClip {
	private static var instance:Main;
	
    public static function main() : Void {
		var main = getInstance();
		flash.Lib.current.addChild( main );
		main.init();
    }
	
	public static function getInstance() : Main {
		if ( null == instance ) {
			instance = new Main();
		}
		return instance;
	}
	
	function init() {
		Registry.set("stage", this.stage );
		
		Bootstrap.init();
        ApplicationController.main();
		PhysicsController.init();	
	}
}
