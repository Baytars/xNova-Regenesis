/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

package org.uinator.utils;

import org.uinator.io.adapter.Adapter;

/**
 *
 * @author nikelin
 */
public class Log {

    private Adapter _adapter;
    private boolean _debug;

    public void setAdapter( Adapter adapter ) {
        this._adapter = adapter;
    }

    public Adapter getAdapter() {
        return this._adapter;
    }

    public void write( Object message ) {
        try {
            this._adapter.write(message.toString());
        } catch( Exception e ) {
            e.printStackTrace();
        }
    }

    public void setDebug( boolean mode ) {
        this._debug = mode;
    }

    public String read() {
        try {
            return this._adapter.read();
        } catch ( Exception e ) {
            e.printStackTrace();
            return null;
        }
    }
}
