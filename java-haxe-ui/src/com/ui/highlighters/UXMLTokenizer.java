package com.ui.highlighters;

import java.util.HashMap;
import java.util.ArrayList;

public class UXMLTokenizer implements Tokenizer {

	private ArrayList<Token> _tokens;
	
	public static final int TOKEN_NONE = 0;
	public static final int TOKEN_NODE_NAME = 1;
	public static final int TOKEN_ATTR_NAME = 2;
	public static final int TOKEN_ATTR_VALUE = 3;
	public static final int TOKEN_NODE_BRACKETS = 4;
	public static final int TOKEN_CDATA_NODE = 5;
	public static final int TOKEN_XMLNS_DECL = 6;
	public static final int TOKEN_XMLNS_CALL = 7;
	public static final int TOKEN_SINGLE_QUOTE = 8;
	public static final int TOKEN_DOUBLE_QUOTE = 9;
	public static final int TOKEN_NODE = 10;
	
	private int context = TOKEN_NONE;
	private String tokenBuff;
	
	public UXMLTokenizer() {
		this._tokens = new ArrayList<Token>();
	}
	
	public void process( String data ) {
		this.tokenBuff = new String();
		for ( int pos = 0; pos < data.length(); pos++ ) {
			this._tokens.add( new Token( this.processCharacter( data.charAt(pos) ), data.charAt(pos), pos ) );
		}
	}
	
	public Token[] getTokens() {
		return (Token[])this._tokens.toArray( new Token[this._tokens.size()] );
	}
	
	protected int processCharacter( char character ) {
		int type = TOKEN_NONE;
		switch( character ) {
		case ' ':
		case '\n':
		case '\r':
		case '\t':
			if ( this.context == TOKEN_NODE_NAME ) {
				this.context = TOKEN_NODE;
			}
		break;
		case '<':
		case '>':
			type = TOKEN_NODE_BRACKETS;
		break;
		case '"':
			type = TOKEN_DOUBLE_QUOTE;
		break;
		case '\'':
			type = TOKEN_SINGLE_QUOTE;
		break;
		case '/':
			if ( this.context != TOKEN_NODE_NAME ) {
				type = TOKEN_NONE;
			}
		break;
		default:
			if ( ( this.context == TOKEN_DOUBLE_QUOTE || this.context == TOKEN_SINGLE_QUOTE )
					&& this.context != TOKEN_NONE ) {
				this.context = TOKEN_ATTR_VALUE;
			} else if ( this.context == TOKEN_NODE_BRACKETS ) {
				if ( this.context != TOKEN_NONE ) {
					this.context = TOKEN_NODE;
				}
			}
		}
		
		this.context = type;
		if ( this.context != TOKEN_NONE ) {
			this.tokenBuff.concat( String.valueOf( character ) );
		}
		
		return type;
	}
	
}
