package;

import core.DrawMap;
import flash.display.MovieClip;
import core.Utilities;

class Main extends MovieClip{
	private static var instance:Main;
	
	override public function new() {
		super();
		
		flash.Lib.current.addChild( this );
	}
	
	static function main() {
		var _dmap:DrawMap = new DrawMap();
		getInstance().addChild( _dmap );
	}
	
	public static function getInstance() {
		if ( instance == null ) {
			instance = new Main();
		}
		
		return instance;
	}
}
