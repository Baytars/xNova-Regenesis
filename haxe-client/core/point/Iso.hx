package core;

class IsoPoint extends core.Point {
		
	private var z:Int;
		
	public function getZ() {
		return this.z;
	}
	
	public function setZ( value:Float ) {
		this.z = value;
		return this;
	}
	
	public function getX() {		
		// cartesian coordinates
		xCart = (x-z)*Math.cos(0.46365);
		// flash coordinates
		xI = xCart + stage.stageWidth / 2;
		return (xI);
	}
	
	public function getY() {		
		// cartesian coordinates
		yCart = this.y + ( this.x + this.z ) * Math.sin( 0.46365 );
		// flash coordinates
		yI = -yCart + stage.stageHeight - 30;
		return (yI);
	}
	

}
