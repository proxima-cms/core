(function() {

	tinymce.create('tinymce.plugins.Proxima_Assets', {

		init : function(ed, url) {

			ed.addCommand('mceProximaAssets', function() {

				ed.windowManager.open({
					file : ed.settings.file_browser_url,
					title: 'Asset Manager',
					width : 720,
					height : 462,
					inline: 1,
					popup_css : false
				},
				{
					plugin_url : url
				});
			});

			// register asset manager button
			ed.addButton('proxima_assets', {
				title : 'Insert/edit asset',
				cmd : 'mceProximaAssets',
				image : url + '/img/images.png'
			});
		},

		getInfo : function() {
			return {
				longname : 'Asset Manager',
				author : 'Richard Willis',
				authorurl : 'http://badsyntax.co',
				infourl : 'http://github.com/badsyntax',
				version : "0.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('proxima_assets', tinymce.plugins.Proxima_Assets);
})();
