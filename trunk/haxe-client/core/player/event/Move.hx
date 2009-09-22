package core.player.event;

import flash.geom.Point;

class Move {
	
	public function  new(player:Player, start_point:Point, end_point:Point ) {
		this.start_point = sp;
		this.end_point = ep;
	} 
	
	public function getEndPoint() : Point {
		return this.end_point;
	}
	
	public function getStartPoint() : Point {
		return this.start_point;
	}
	
}
