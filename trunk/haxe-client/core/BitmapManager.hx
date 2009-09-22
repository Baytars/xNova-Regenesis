package core;

import flash.display.Loader;
import flash.display.BitmapData;
import flash.net.URLRequest;

class BitmapManager implements core.observer.Interface {

	private static var instance:BitmapManager;
	private var _observer:Observer;
	private var cache:Hash<Loader>;

	public static function getInstance() {
		if ( instance == null ) {
			instance = new BitmapManager();
		} 
		
		return instance;
	}
	
	public function addListener( type:String, fn:Dynamic ) : Dynamic {
		this._observer.addListener(type,fn);
		return this;
	}
	
	public function fireEvent( type:String, ?event:core.events.Event ) : Bool {
		return this._observer.fireEvent(type, event);
	}
	
	public function hasListener( type:String, fn:Dynamic ) : Bool {
		return this._observer.hasListener(type, fn);
	}
	
	function new() {
		this.cache = new Hash<Loader>();
	}
	
	
	public function getImage( url:String ) {
		var data = this.cache.get(url);
		if ( data == null ) {
			var loader:Loader = new Loader();
			loader.load( new URLRequest(url) );
			
			this.cache.set(url, loader);
			return loader;
		}
		
		return data;
	}

}
