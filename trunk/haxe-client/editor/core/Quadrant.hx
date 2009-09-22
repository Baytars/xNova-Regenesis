package core;

import flash.geom.Point;

class Quadrant extends QuadrantProperties {
    private var _name:String;
    private var _src:String;
	private var _mc:flash.display.MovieClip;
    
	override public function new( ?point:Point, ?width:Int, ?height:Int )  {
		super(point, width, height);		
	}
	
	public static function create(data:Dynamic) {
		var q = new Quadrant( new Point(data.x, data.y) );
		
		return q;
	}
	
    override public function render() : flash.display.DisplayObject {
		this.graphics.clear();
		this.graphics.beginFill(this.getColor());
		this.graphics.drawRect(this.getX(), this.getY(), this.getWidth(), this.getHeight());
		this.graphics.endFill();
		return this;
    }
}
