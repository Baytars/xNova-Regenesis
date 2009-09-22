package core;
import flash.geom.Point;
import core.Map;

class Edit {
	
	public var _quadrants:List<Quadrant>;
	public var _selected_quadrants:List<Quadrant>;
	public var _edited_quadrants:List<Quadrant>;
	
	public function new(){
	}

	public function returnEditedMap(){
		return this._edited_quadrants;
	}

	public function getMap(quad:List<Quadrant>){
		this._selected_quadrants = quad;
	}

	public function changeColor(color:Int){
		var q:Quadrant;
		for ( q in this._selected_quadrants ) q.setColor(color);
		this.returnEditedMap();
	}
}
