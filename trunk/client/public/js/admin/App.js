var App = {
    'start' : function() {
        var viewport = new Ext.Viewport({
            layout : 'border',
            items : [{
                region : 'north',
                xtype : 'panel',
                html : "xNovaes AdminStation"
            }, {
                region : 'right',
                xtype : 'panel',
                items : [
                    new Ext.menu.Menu({
                        items : [{
                            text : 'На главную'
                        }]
                    })
                ]
            }]
        });
    }
}