package core.events.player;

import flash.geom.Point;
import core.Player;

class Move extends core.events.Event {
	private var _start_point:Point;
	private var _end_point:Point;
	
	override public function new( target:Player, start_point:Point, end_point:Point ) {
		super(target);
		
		this._start_point = start_point;
		this._end_point = end_point;
	}
	
	public function getStartPoint() : Point {
		return this._start_point;
	}

	public function getEndPoint() : Point {
		return this._end_point;
	}
}
