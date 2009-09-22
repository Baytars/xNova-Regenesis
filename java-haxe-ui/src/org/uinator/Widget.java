package org.uinator;

import java.util.ArrayList;

public class Widget {
	private Layout _layout;
	public ArrayList<Widget> _widgets;
	
	public Widget() {
		this._widgets = new ArrayList<Widget>();
	}
	
	public Widget addWidget( Widget w ) {
		this._widgets.add(w);
		return w;
	}
	
	public Layout getLayout() {
		return this._layout;
	}
	
	public void setLayout( Layout l ) {
		this._layout = l;
	}
	
	public ArrayList<Widget> getWidgets() {
		return this._widgets;
	}
}
