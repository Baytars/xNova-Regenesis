var App = {
	'start' : function() {
		var viewport = new Ext.Viewport({
			layout : 'border',
			items : [
		         {
					xtype : 'panel',
					region : 'north',
					layout : 'border',
					height : 50,
					items : [
						new Ext.Toolbar({
							region : 'center',
							height : 30,
							items : [{
								text : 'Planets'
							}, {
								text : 'Ships'
							}, {
								text : 'Resources'
							}, {
								text : 'Galaxies'
							}, {
								text : 'Settings'
							}, {
								text : 'Users'
							}]
						}), {
							region : 'north',
							html : 'xNovaes Administration'
						}
					],
		         },
				{
					region : 'center',
					type : 'panel',
					layout : 'border',
					items : [{
						region : 'center',
						type : 'panel'
					}, {
						region : 'west',
						type : 'panel',
						html : "Stats",
						width : 150
					}]
				},     
				{
					region : 'south',
					xtype : 'panel',
					html : 'Project xNovaes, 2009'
				}
			]
		});
	}
}