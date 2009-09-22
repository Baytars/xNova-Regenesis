package core;

import flash.display.MovieClip;
import flash.display.Stage;
import flash.text.TextField;
import flash.text.TextFieldType;
import flash.text.TextFieldAutoSize;
import flash.events.TextEvent;
import flash.events.Event;
import flash.events.MouseEvent;
import flash.events.KeyboardEvent;
import core.Map;
import core.Utilities;
import core.Edit;
import core.ContextMenu;
import flash.geom.Point;

class DrawMap extends MovieClip {
	
	private var widthField:TextField;
	private var widthLabel:TextField;
	private var heightField:TextField;
	private var heightLabel:TextField;
	private var submit:TextField;
	private var apply:TextField;
	private var edit_menu:TextField;
	private var label:TextField;
	private var edit:Edit;
	private var utils:Utilities;
	private var map:Map;
	private var colorField:TextField;
	
	override public function new() {
		super();
		
		this.utils = new Utilities();
		this.edit = new Edit();
		
		this.label = this.utils.makeTextField(10, 10, 400, 30, "input map dimensions");
		this.addChild(this.label);
		
		this.widthField = this.createWidthField();
		this.widthLabel = this.utils.makeTextField(10, 40, 30, 20, "width");
		this.addChild(this.widthField);
		this.addChild(this.widthLabel);
		
		this.heightField = this.createHeightField();		
		this.heightLabel = this.utils.makeTextField(10, 65, 35, 20, "height");
		this.addChild(this.heightField);
		this.addChild(this.heightLabel);

		this.submit = this.createSubmitButton();
		this.addChild(this.submit);
		
		this.apply = this.createApplyButton();
		this.addChild(this.apply);
		
		this.editMenu();
	}

	private function onCreateMap( event:flash.events.MouseEvent ) {
		this.map = new Map(new Point(0,0), Std.parseInt( this.widthField.getRawText() ), Std.parseInt( this.widthField.getRawText() ) );
		this.map.x = 150;
		this.map.y = 50;
		this.addChild(this.map.render());
	}
	
	private function createSubmitButton() {
		var submit = this.utils.makeTextField(10, 90, 100, 20, "<a href='event:'>submit</a>");
		submit.addEventListener("click", this.onCreateMap );
		
		return submit;
	}
	
	private function createApplyButton() {
		var apply = this.utils.makeTextField(50, 90, 100, 20, "<a href='event:'>apply</a>");
		apply.addEventListener("click", this.onApply);
		return apply;
	}
	
	private function onApply( event:flash.events.Event ) {
		this.edit.getMap( this.map.getSelectedQuadrants() );
		this.edit.changeColor(Std.parseInt(this.colorField.getRawText()));
		this.addChild(this.map.render());
	}
	
	private function createWidthField() {
		var widthField:TextField = this.utils.makeInputField(50, 40, 35, 17);
		widthField.maxChars = 4; 
		widthField.restrict = "0-9";
		
		return widthField;
	}
	
	private function createHeightField() { 
		var heightField:TextField = this.utils.makeInputField(50, 65, 35, 17);
		heightField.maxChars = 4; 
		heightField.restrict = "0-9";
		
		return heightField;
	}
	
	public function editMenu(){
		var colorLabel:TextField = this.utils.makeTextField(10, 150, 35, 20, "color: ");
		this.colorField = this.utils.makeInputField(50, 150, 50, 17);
		this.addChild(colorLabel);
		this.addChild(colorField);
		
	}
	
}
