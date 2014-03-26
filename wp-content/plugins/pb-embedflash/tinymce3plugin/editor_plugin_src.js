( function() {
	tinymce.create('tinymce.plugins.pbembedFlash',
	{
		init: function(ed,url)
		{
			ed.addCommand('mcepbembedFlash',function() {
				ed.windowManager.open({
					file: url+'/pb-embedFlash-tinymceplugin.php',
					width: 520+ed.getLang('pbembedFlash.delta_width',0),
					height: 275+ed.getLang('pbembedFlash.delta_height',0),
					inline: 1
				}, {
					plugin_url:url
				});
			});
			ed.addButton('pbembedFlash', {
				title: 'pb-embedFlash',
				cmd: 'mcepbembedFlash',
				image: url+'/pbembedFlash.png'
			});
			ed.onNodeChange.add(function(ed,cm,n) {
				cm.setActive('pbembedFlash',n.nodeName=='IMG');
			});
		},
		createControl: function(n,cm) {
			return null;
		},
		getInfo: function() { return {
			longname: 'pb-embedFlash',
			author: 'Pascal Berkhahn',
			authorurl: 'http://pascal-berkhahn.de',
			infourl: 'http://pascal-berkhahn.de/pb-embedFlash',
			version: '1.0'
		}; }
	});
	tinymce.PluginManager.add('pbembedFlash',tinymce.plugins.pbembedFlash);
})();