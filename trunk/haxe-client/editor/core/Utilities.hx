package core;

import flash.display.MovieClip;
import flash.display.Stage;
import flash.text.TextField;
import flash.text.TextFieldType;
import flash.text.TextFieldAutoSize;
import flash.events.TextEvent;

class Utilities {
	
	public function new() {
	}
	
	public function makeTextField(x:Int, y:Int, width:Int, height:Int, ?label:String){
		var field:TextField = new TextField();
		field.x = x;
		field.y = y;
		field.width = width;
		field.height = height;
		field.htmlText = label;
		return field;
	}
	
	public function makeInputField(x:Int, y:Int, width:Int, height:Int){
		var field:TextField = new TextField();
		field.x = x;
		field.y = y;
		field.width = width;
		field.height = height;
		field.type = TextFieldType.INPUT; 
		field.border = true;
		return field;
	}

}
