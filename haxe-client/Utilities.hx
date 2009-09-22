import flash.display.MovieClip;
import flash.display.Stage;
import flash.text.TextField;
import flash.text.TextFieldType;
import flash.text.TextFieldAutoSize;
import flash.events.TextEvent;

class Utilities {
	
	public function new(){
	}
	public function makeTextField(x:Int, y:Int, width:Int, height:Int){
		var name:TextField = new TextField();
		name.x = x;
		name.y = y;
		name.width = width;
		name.height = height;
		return name;
	}
}
