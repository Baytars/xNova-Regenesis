import flash.display.MovieClip;
import flash.display.Stage;
import flash.text.TextField;
import flash.text.TextFieldType;
import flash.text.TextFieldAutoSize;
import flash.events.TextEvent;
import flash.events.Event;
import core.Map;
import core.MapBuilder;
import core.Point;
import Utilities;

class Test extends MovieClip {
	static function main() {
			var u = new Utilities();
		    var label = u.makeTextField(10, 10, 400, 30);
			label.text = "input map dimensions";
			var width:TextField = u.makeTextField(10, 40, 30, 20);
			width.text = "widht:";
			var _width:TextField = u.makeTextField(50, 40, 35, 17);
			_width.type = TextFieldType.INPUT; _width.border = true; _width.maxChars = 4; _width.restrict = "0-9";
			var height:TextField = u.makeTextField(10, 65, 35, 20);
			height.text = "height:";
			var _height:TextField = u.makeTextField(50, 65, 35, 17);
			_height.type = TextFieldType.INPUT; _height.border = true; _height.maxChars = 4; _height.restrict = "0-9";
			var submit:TextField = u.makeTextField(10, 90, 100, 20);
			submit.htmlText = "<a href='event:"+_width.text+"'>submit</a>";
			submit.addEventListener("click", function(event:flash.events.Event){
												var x:Dynamic = _width.getRawText();
												var y:Dynamic = _height.getRawText();
												var map = new Map(new Point<Int>(0,0), x, y);
												trace ("success!");
												map.x = 150;
												map.y = 50;
												flash.Lib.current.addChild(map);});

			flash.Lib.current.addChild(label);
			flash.Lib.current.addChild(width);
			flash.Lib.current.addChild(_width);
			flash.Lib.current.addChild(height);
			flash.Lib.current.addChild(_height);
			flash.Lib.current.addChild(submit);
	}
}
