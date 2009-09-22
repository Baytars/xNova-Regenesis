package core;

import core.events.Event;

class Observer implements core.observer.Interface {

    private var _listeners:Hash<List<Dynamic>>;
    
    public function new() {
        this._listeners = new Hash<List<Dynamic>>();
    }

    public function addListener( type:String, fn:Dynamic ) : Dynamic {
        if ( !this.hasListener( type, fn) ) {
            this._listeners.set(type, new List<Dynamic>());
        }
        
        this._listeners.get(type).add(fn);
        return this;
    }
    
    public function hasListener( type:String, fn:Dynamic ) : Bool {
        return this._listeners.exists(fn);
    }
	
	public function handleEvent( type:String ) {
		return this._listeners.exists(type);
	}
    
    public function fireEvent(type : String, ?event:core.events.Event ) : Bool {
        var result:Bool = true;
		
		if ( this.handleEvent(type) ) { 
			for ( listener in this._listeners.get(type) ) {
				result = result && listener(event);
			}
		}
        
        return result;
    }
}
