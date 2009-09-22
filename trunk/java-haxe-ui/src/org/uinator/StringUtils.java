package org.uinator;

enum StringCase {
	UPPER,
	LOWER;
}

public class StringUtils {
	public static String toCamelCase( String name, String delimiter, StringCase wordCase ) {
		String result = new String();
		
		for ( int i = 0; i < name.length(); i++ ) {
			String prevChar = name.substring( i > 0 ? i-1 : 0, i > 0 ? i : 1);
			String currChar = name.substring(i, i+1);
			
			switch ( wordCase ) {
			case UPPER:
				if ( prevChar.equals(delimiter)  || ( i == 0 && !currChar.equals(delimiter) ) ) {
					result = result.concat( currChar.toUpperCase() );
				} else {
					result = result.concat(currChar);
				}
			break;
			case LOWER:
				if ( currChar.toUpperCase() == currChar ) {
					result = result.concat( delimiter ).concat( currChar.toLowerCase() );
				} else {
					if ( i == 0 ) {
						result = result.concat(delimiter);
					}
					
					result = result.concat(currChar);
				}		
			break;
			}
		}
		
		return result;
	}
}
