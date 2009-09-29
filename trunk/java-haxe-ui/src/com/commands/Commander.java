package com.commands;

public interface Commander {

	public void processCommand( CommandType ct, Object data );
	
}
