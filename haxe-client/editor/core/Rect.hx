package core;

import core.Shape;
import flash.geom.Point;

class Rect extends Shape {
	private var _width:Int;
	private var _height:Int;
		
	public function new( point:Point, width:Int, height:Int ) {
		super(point);
		
		this._width = width;
		this._height = height;
	}
		
	public function getWidth() : Int {
		return this._width;
	}
	
	public function getHeight() : Int {
		return this._height;
	}
	
	public function setWidth( value:Int ) {
		this._width = value;
		return this;
	}
	
	public function setHeight( value:Int ) {
		this._height = value;
		return this;
	}
	
	public function checkCollision( point:Point ) : Bool {
		return true;
		//@TODO
		//return pint.getDistance(this.getPoint(), point) < this.getHeight() / 3;
	}
}
