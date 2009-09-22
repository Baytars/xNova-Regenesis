package core;

import flash.net.URLLoader;
import flash.net.URLRequest;
import flash.events.Event;
import hxjson2.JSON;
import core.Quadrant;
import flash.geom.Point;

class MapBuilder implements core.observer.Interface {

    private var _observer:Observer;
    private var _loader:URLLoader;
    
    public function new() {
        this._observer = new Observer();
    }
    
    public function getLoader() {
        if ( this._loader == null ) {
            this._loader = new URLLoader();
        }
        
        return this._loader;
    }
    
    public function loadData( cb:Dynamic ) {
        var request = new URLRequest();
        request.url = Registry.get("config").web.path.map;
        request.method = "POST";
        
        this.getLoader().addEventListener( "complete", function( e:Event ) {
            var data = e.target.data;
            // Преобразуем полученный ответ сервера (JSON) в нативный HaXe-объект(Hash)
			var result = JSON.decode(data).map;
			cb(result);
        });
        this.getLoader().load( request );
    }
	
    public function fireEvent( type:String, ?event:core.events.Event ) : Bool {
        return this._observer.fireEvent(type, event);
    }
    
    public function hasListener( type:String, fn:Dynamic ) : Bool {
        return this._observer.hasListener(type, fn);
    }
    
    public function addListener( type:String, fn:Dynamic ) : Dynamic {
        this._observer.addListener( type, fn );
        return this;
    }
    
    public function buildFromXml( data:String ) : Map {
    	var doc:Xml = Xml.parse(data).firstElement();
    	var map:Map = new Map();
    	
    	var map_settings = doc.elementsNamed("settings").next();
    	if ( map_settings != null ) {
    		map.setWidth( Std.parseFloat( map_settings.elementsNamed("width").next().firstChild().nodeValue ) );
    		map.setHeight( Std.parseFloat( map_settings.elementsNamed("height").next().firstChild().nodeValue ) );
    	}
    	
    	var view_settings = map_settings.elementsNamed("view").next();
    	var rows = Std.parseInt( view_settings.elementsNamed("rows").next().firstChild().nodeValue );
    	var cells = Std.parseInt( view_settings.elementsNamed("columns").next().firstChild().nodeValue );
    	var quadrants = doc.elementsNamed("quadrants").next();
    	
    	for ( row in 0...rows ) {
    		for ( cell in 0...cells ) {
    			var src = null;
    			for ( node in quadrants.elements() ) {
    				if ( Std.parseInt( node.get('cell') ) == cell && Std.parseInt( node.get('row') ) == row ) {
    					src = node.elementsNamed("src").next().firstChild().nodeValue;
    					break; 
    				}
    			}
    			
    			map.addQuadrant( 
    				new Quadrant( 
	    					new Point( cell*10 + 20, row * 10 + 20 ), 
    						10, //Std.parseFloat( view_settings.elementsNamed("width").next().firstChild().nodeValue ), 
    						10, //Std.parseFloat( view_settings.elementsNamed("height").next().firstChild().nodeValue )
							"http://haxe.org/img/haxe/flags/flag_fr.gif"
					), 
				row + '_' + cell );
    		}
    	}
    	
    	return map;
    }
    
}
