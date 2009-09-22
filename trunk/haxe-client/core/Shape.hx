package core;

import flash.geom.Point;

class Shape extends flash.display.MovieClip {

	private var _point:Point;
	
	override public function new( ?point:Point ) {
		super();
		
		this._point = point;
		
		if ( point != null ) {
			this.x = point.x;
			this.y = point.y;
		}
	} 
	
	public function setPoint( point:Point ) {
		this._point = point;
		this.x = point.x;
		this.y = point.y;
	}

	public function setX( value:Float ) : Dynamic {
		this._point.x = value;
		this.x = value;
		return this;
	}
	
	public function setY( value:Float ) : Dynamic {
		this.y = value;
		this._point.x = value;
		return this;
	}
	
	public function render() : flash.display.DisplayObject {
		return null;
	}
	
	public function getX() : Float {
		return this.x;
	}
	
	public function getY() : Float {
		return this.y;
	}

	public function getPoint() : Point {
		return this._point;
	}
	
	public function setName( value:String ) {
		this.name = value;
		return this;
	}
	
	public function getName() : String {
		return this.name;
	}
}
