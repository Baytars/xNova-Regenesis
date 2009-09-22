package org.uinator.readers;

import java.util.ArrayList;

public class Node {

	private Object _value;
	private String _name;
	private ArrayList<Node> _attributes;
	private ArrayList<Node> _childs;
	private Node _parent;
	
	public Node() {
		this._attributes = new ArrayList<Node>();
		this._childs = new ArrayList<Node>();
	}
	
	public Node( String name, Object value ) {
		this._value = value;
		this._name = name;
	}
	
	public Node setValue( Object value ) {
		this._value = value;
		return this;
	}
	
	public Node addChild( Node child ) {
		this._childs.add( child );
		return this;
	}
	
	public Node addAttribute( String name, String value ) {
		this._attributes.add( new Node( name, value ) );
		return this;
	}
	
	public ArrayList<Node> getAttributes() {
		return this._attributes;
	}
	
	public ArrayList<Node> getChilds() {
		return this._childs;
	}
	
	public Node setParent( Node parent ) {
		this._parent = parent;
		return this;
	}
	
	public String getName() {
		return this._name;
	}
	
	public Node setName( String name ) {
		this._name = name;
		return this;
	}
	
	public Object getValue() {
		return this._value;
	}
	
}
