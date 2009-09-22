package core.utils;

import StringTools;

class Config {
    
    public static function parse( s:String ) : Hash<Dynamic> {
        var result:Hash<Dynamic> = new Hash<Dynamic>();
        
        var lines:Array<String> = s.split("\n");
        for( line in lines ) {
            var parts = line.split("=");
            
            if ( parts.length > 1 ) {
                var name = Config.sanitize( parts[0] );
                var value = Config.sanitize( parts[1] );
                
                var result_hash:Hash<Dynamic> = new Hash<Dynamic>();
                var curr_hash:Hash<Dynamic> = null;
                var curr_path_name:String = null;
                for ( path_part in name.split(".") ) {
                    var part = new Hash<Dynamic>();
                    if ( curr_hash == null ) {
                        result_hash.set( path_part, part);
                    } else {
                        curr_hash.set( path_part, part );
                    }
                    curr_hash = part;
                    curr_path_name = path_part;
                }
                
                curr_hash.set( curr_path_name, value );
            }
        }
        
        return result;
    }
    
    private static function sanitize( line:String ) : String {
        var result:Dynamic = null;
        result = StringTools.trim(line);
        result = StringTools.htmlEscape(line);
        
        if ( result.length > 0 ) {
            if ( StringTools.startsWith(result, "\"") ) {
                result= line.substr(1);
            }
        
            if ( StringTools.endsWith(result, "\"") ) { 
                result = line.substr(0, line.length );
            }
            
            switch ( result.toLowerCase() ) {
                case 'false':
                    result= false;
                case 'true':
                    result = true;
                case 'null':
                    result = null;
            }
        } else {
            result = null;
        }
    
        
        return line;
    }
}
