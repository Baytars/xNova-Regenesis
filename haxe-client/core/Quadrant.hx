package core;

import core.Observer;
import core.Rect;
import flash.events.Event;
import flash.display.DisplayObject;
import flash.geom.Point;

class Quadrant extends Rect, implements core.observer.Interface {
    private var _observer:Observer;
    private var _src:String;
	private var _cell:Int;
	private var _row:Int;
	
	override public function new( ?point:Point, ?width:Float, ?height:Float, ?src:String )  {
		super(point, width, height);
		
		this.addEventListener( Event.ADDED_TO_STAGE, doRender );
		
		this._src = src;
	}
	
	public function doRender( e:Event ) : Void {
		var img:DisplayObject = BitmapManager.getInstance().getImage( this._src );
		this.addChild(img);
	}
	
    public function hasListener( type:String, fn:Dynamic ) : Bool{
        return this._observer.hasListener(type, fn);
    }
    
    public function addListener(type:String, fn:Dynamic ) : Dynamic {
        this._observer.addListener(type, fn);
        return this;
    }
    
    public function fireEvent( type:String, ?event:core.events.Event ) : Bool{
        return this._observer.fireEvent(type, event);
    }
    
	public function setSrc( value:String ) : Quadrant {
		this._src = value;
		return this;
	}
	
    public function getSrc() : String { 
        return this._src;
    }   
	
	public function getRow() : Int {
		return this._row;
	}
	
	public function setRow( value:Int ) : Quadrant {
		this._row = value;
		return this;
	}
	
	public function getCell( value:Int ) : Int {
		return this._cell;
	}
	
	public function setCell( value:Int ) :Quadrant {
		this._cell = value;
		return this;
	}
}
