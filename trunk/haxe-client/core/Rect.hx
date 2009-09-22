package core;

import core.Shape;
import flash.geom.Point;

class Rect extends Shape {
	private var _width:Float;
	private var _height:Float;
		
	public function new( point:Point, width:Float, height:Float ) {
		super(point);
		
		this._width = width;
		this._height = height;
	}
		
	public function getWidth() : Float {
		return this._width;
	}
	
	public function getHeight() : Float {
		return this._height;
	}
	
	public function setWidth( value:Float ) {
		this._width = value;
		return this;
	}
	
	public function setHeight( value:Float ) {
		this._height = value;
		return this;
	}
	
	public function checkCollision( point:Point ) : Bool {
		return Point.distance( this.getPoint(), point ) < this.getHeight() / 3;
	}
	
	override public function render() : flash.display.DisplayObject {
		this.graphics.clear();
		this.graphics.beginFill(0x005005);
		this.graphics.drawRect( this.getX(), this.getY(), this.getWidth(), this.getHeight() );
		this.graphics.endFill();
		return this;
    }
}
