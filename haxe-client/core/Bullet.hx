package core;

import controllers.PhysicsController;
import flash.geom.Point;

class Bullet extends core.Shape {
	private var _type:core.bullets.BulletType;

	override public function new( ?point:Point, name:String, ?type:core.bullets.BulletType ) {
		super(point);
		this._type = new core.bullets.BulletType();
		//this.setName(name);
		
		PhysicsController.bindBullet( this );
	}
	
	public function setType( type:core.bullets.BulletType ) {
		this._type = type;
		return this;
	}
	
	public function getType() {
		return this._type;
	}
	
	public function getDamageType() {
		this.getType().getDamageType();
	}
	
	override public function render() : flash.display.DisplayObject {
		this.graphics.clear();
		this.graphics.beginFill( 0xFF0055 );
		this.graphics.drawCircle( 0, 0, 2 );
		this.graphics.endFill();
		
		return this;
	}
}
