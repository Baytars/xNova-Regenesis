package com.ui.highlighters;

import java.awt.Color;

import javax.swing.text.BadLocationException;
import javax.swing.text.JTextComponent;
import javax.swing.text.Highlighter;
import javax.swing.text.DefaultHighlighter;

public class UXMLHighlighter {
	
	Highlighter.HighlightPainter painter = new HiPainter(Color.red);
	
	public void highlight( JTextComponent cmp, Tokenizer t ) throws BadLocationException {
		Highlighter hi = cmp.getHighlighter();
		hi.removeAllHighlights();
		
		int pos = 0;
		for ( Token token:t.getTokens() ) {
			hi.addHighlight( token.getPos(), token.getSmb(), painter );
		}
	}
	
	protected class HiPainter extends DefaultHighlighter.DefaultHighlightPainter {

		public HiPainter(Color color) {
			super(color);
			
		}
		
	}
	
}
