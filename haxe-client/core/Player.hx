package core;

import core.Observer;
import core.Gun;
import flash.geom.Point;
import flash.display.DisplayObject;
//@TODO заменить коды - константами
import flash.ui.Keyboard;
import core.Shape;

class Player extends Shape, implements core.observer.Interface {
	private var _id:Int;
	private var _gun:Gun;
	private var _sync_time:Int;
	private var _sync_interval:Int;
	private var _accel:Float;
	private var _observer:Observer;
	private var _map:Map;
	static private var _instance:Player;
	
	
	override public function new( ?id:Int ) {
		super();
		
		this._observer = new Observer();
		this.setPoint( new Point(200, 60 ) );
		this._gun = new Gun();
		this.setId(id);
		this.setAccel(2);
		this.initEvents();
	}
	
	public static function getInstance() : Player {
		if ( _instance == null ) {
			_instance = new Player();
		}
		
		return _instance;
	}
	
	public function addListener( type:String, fn:Dynamic ) : Dynamic {
		this._observer.addListener( type, fn );
		return this;
	}
	
	public function fireEvent( type:String, ?event:core.events.Event ) : Bool { 
		return this._observer.fireEvent(type, event );
	}
	
	public function hasListener( type:String, fn:Dynamic ) : Bool { 
		return this._observer.hasListener( type, fn );
	}
	
	// Необходимо реализовать подгрузку информации об объекте персонажа 
	private function syncData(cb) : Void {
		cb();
	}
	
	public function getId() : Int {
		return this._id;
	}
	
	/**
	 * Синхронизированны ли данные с сервером и не устарели ли они
	 * 
	 * @return bool
	 */
	public function isSync() : Bool {
		return this._sync_time == 0 || Date.now().getTime() - this._sync_time < this._sync_interval;
	}
	
	public function attachToMap( map:Map ) : Player {
		this._map = map;
		this._map.addChild( this.render() );
		return this;
	}
	
	public function getCurrentMap() : Map {
		return this._map;
	}
	
	/**
	 * Идентификатор персонажа для получении данных с сервера
	 * @return core.Player
	 */
	private function setId( value:Int ) : Player {
		this._id = value;
		return this;
	}
	
	/**
	 * Получаем вертикальную скорость передвижения игрока по карте
	 * 
	 * @return Int
	 */
	public function getYSpeed() : Float {
		if ( getCurrentMap() != null ) {
			return this.getAccel(); // / getCurrentMap().getHeight();
		}
		
		return 0;
	}
	
	
	/**
	 * Получаем горизонтальную скорость передвижения игрока по карте
	 * 
	 * @return Int
	 */
	public function getXSpeed() : Float {
		if ( getCurrentMap() != null) {
			return this.getAccel();// / getCurrentMap().getWidth();
		}
		
		return 0;
	}
	
	public function setAccel( value:Float ) : Player {
		this._accel = value;
		return this;
	}
	
	public function getAccel() : Float {
		return this._accel;
	}
	
	public function moveUp() : Void {
		this.moveToPoint( this.getX(), this.getY() - this.getYSpeed() );
	}
	
	public function moveLeft() : Void {
		this.moveToPoint( this.getX() - this.getXSpeed(), this.getY() );
	}
	
	public function moveDown() : Void{
		this.moveToPoint( this.getX(), this.getY() + this.getYSpeed() );
	}
	
	public function moveRight() : Void {
		this.moveToPoint( this.getX() + this.getXSpeed(), this.getY() );
	}
	
	public function canMoveTo( start_point:Point, end_point:Point) {
		return this.fireEvent( "beforemove", new core.events.player.Move(this, start_point, end_point ) );
	}
	
	// Изменить функцию с учётом проложения пути к точке, а не мгновенной телепортации
	public function moveToPoint( x:Float, y:Float) : Void {
		var end_point:Point = new Point(x, y);
		var start_point:Point = new Point( this.getX(), this.getY() );
		
//		var path = core.Utils.PathFind.getPoints( end_points, start_point );
		
		if ( this.canMoveTo( start_point, end_point ) ) {
			this.setPoint(end_point);
			this.fireEvent("move", new core.events.player.Move( this, start_point, end_point ) );
		}
	}
	
	public function setGun( gun:Gun ) : Player {
		this._gun = gun;
		return this;
	}
	
	public function shoot() : Void {
		this._gun.shoot( this.getPoint() );
	}
	
	private function keyEventsHandler(e:flash.events.KeyboardEvent) : Void{
		switch(e.keyCode) {
			case Keyboard.SPACE:
				this.shoot();
			case Keyboard.UP:
				this.moveUp();
			case Keyboard.DOWN:
				this.moveDown();
			case Keyboard.LEFT:
				this.moveLeft();
			case Keyboard.RIGHT:
				this.moveRight();
		}
	}
	
	public function initEvents() : Void {
		Registry.get("stage").addEventListener( flash.events.KeyboardEvent.KEY_DOWN, this.keyEventsHandler);
	}
	
	override public function render() : flash.display.DisplayObject {
		var img:DisplayObject = BitmapManager.getInstance().getImage("http://haxe.org/img/haxe/flags/flag_en.gif");
		this.addChild(img);
		
		return this;
	}
}
