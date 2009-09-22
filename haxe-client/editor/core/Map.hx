package core;

import core.Quadrant;
import flash.geom.Point;
import flash.events.MouseEvent;
import core.Edit;

class Map extends Rect{
    public var _quadrants:List<Quadrant>;
	public var _selected_quadrants:List<Quadrant>;
	
    public function new( ?point:Point, ?width:Int, ?height:Int ) {
		super(point, width, height);
		this._quadrants = new List<Quadrant>();
		this._selected_quadrants = new List<Quadrant>();
		var i,j:Int;
		for (i in 0...width){
			for (j in 0...height){
				this.addQuadrant(new Quadrant(new Point(10*i, 10*j), 19, 19), "q "+(i+1)+":"+(j+1));
			}
		}
    }
    
	public function loadQuadrants(quad:List<Quadrant>){
		this._quadrants = quad;
	}
	
    override public function render() : flash.display.DisplayObject {
		for ( quad in this.getQuadrants() ) {
            this.addChild( quad.render() );
			quad.addEventListener(MouseEvent.CLICK, onSelectQuadrant);
        }
		return this;
    }
	
	public function onSelectQuadrant( e:MouseEvent ) {
		if (e.ctrlKey == true){
			var quad:Quadrant = e.target;
			this._selected_quadrants.add( quad );
		}
	}
	
    public function addQuadrant( quadrant:Quadrant, name:String ) {
        quadrant.setName(name);
        this._quadrants.add( quadrant );
        return quadrant;
    }
    
    public function getQuadrants() : List<Quadrant> {
        return this._quadrants;
	}
	public function getSelectedQuadrants() : List<Quadrant> {
        return this._selected_quadrants;
    }
}
