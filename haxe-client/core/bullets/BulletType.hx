package core.bullets;

class BulletType {
	
	private var _damageType:core.Damage;
	
	public function new() {
		this._damageType = new core.Damage();
	}

	public function getDamageType() {
		return this._damageType;
	}

}
