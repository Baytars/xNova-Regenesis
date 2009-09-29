package com.ui.highlighters;

public class Token {

	int type;
	int pos;
	char smb;
	
	public Token( int type, char smb, int pos ) {
		this.type = type;
		this.smb = smb;
		this.pos = pos;
	}
	
	public int getType() {
		return this.type;
	}
	
	public char getSmb() {
		return this.smb;
	}
	
	public int getPos() {
		return this.pos;
	}
	
}
