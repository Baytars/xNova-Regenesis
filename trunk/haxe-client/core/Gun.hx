package core;

import core.Bullet;
import flash.geom.Point;

class Gun {
	private var _bulletType:core.bullets.BulletType;
	
	public function new() {
	
	}
	
	public function shoot( point:Point ) : Void {
		var bullet_id = Date.now().getTime();
		var bullet = new Bullet( point, "Afla" + bullet_id, this._bulletType );

		flash.Lib.current.addChild( bullet.render() );
	}
}
