package core.events;

class Event {
	
	private var _target:core.observer.Interface;
	
	public function new(target:core.observer.Interface) { 
		this._target = target;
	}
	
	public function getTarget() : core.observer.Interface {
		return this._target;
	}

}
