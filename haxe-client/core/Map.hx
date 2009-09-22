package core;

import core.Quadrant;
import flash.geom.Point;

class Map extends Rect, implements core.observer.Interface {
    private var _quadrants:List<Quadrant>;
	private var _observer:Observer;
    
    public function new( ?point:Point, ?width:Float, ?height:Float ) {
        super(point, width, height);
		
		this._quadrants = new List<Quadrant>();
		this._observer = new Observer();
		
		this.render();
    }
	
	public function fireEvent( type:String, ?event:core.events.Event ) : Bool {
		return this._observer.fireEvent(type, event);
	}
	
	public function hasListener( type:String, fn:Dynamic ) : Bool { 
		return this._observer.hasListener(type, fn);
	}
	
	public function addListener( type:String, fn:Dynamic ) : Dynamic {
		this._observer.addListener(type, fn);
		return this;
	} 
	
    override public function render() : flash.display.DisplayObject {
		for ( quad in this.getQuadrants() ) {
            this.addChild( quad.render() );
        }
		
		this.fireEvent("init");
		
		return this;
    }
    
    public function addQuadrant( quadrant:Quadrant, name:String ) {
        quadrant.setName(name);
        this._quadrants.add( quadrant );
        
        return quadrant;
    }
	
	public function getCollisions( p:Point ) : List<Quadrant> {
		var result = new List<Quadrant>();
		
		for ( quad in this.getQuadrants() ) {
			if ( quad.checkCollision(p) ) {
				result.add(quad);
			}
		}
		
		return result;
	}
	
    public function getQuadrants() : List<Quadrant> {
        return this._quadrants;
    }
    
}
