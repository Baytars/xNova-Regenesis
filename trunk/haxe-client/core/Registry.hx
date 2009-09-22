package core;

// Registry singleton
class Registry {
    
    private static var _instance:Registry;
    private var _store:Hash<Dynamic>;
    
    private function new() {
        this._store = new Hash<Dynamic>();
    }

    public static function set( name:String, value:Dynamic ) : Dynamic {
        instance()._store.set(name, value);
        return value;
    }
    
    public static function get( name:String ) : Dynamic {
        return instance()._store.get(name);
    }
    
    public static function isRegistered( name:String ) {
        return instance()._store.exists(name);
    }
    
    private static function instance() {
        if ( _instance == null ) {
            _instance = new Registry();
        }
        
        return _instance;
    }
}
