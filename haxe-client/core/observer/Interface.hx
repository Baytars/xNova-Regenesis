package core.observer;

interface Interface {

    public function addListener( type:String, fn:Dynamic) : Dynamic;
    
    public function hasListener( type:String, fn:Dynamic ) : Bool;
    
    public function fireEvent( type:String, ?event:core.events.Event ) : Bool;

}
