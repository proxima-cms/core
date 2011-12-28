(function(data){

	define([
		'underscore',
		'backbone',
	], function(_, Backbone){

		var IndexView = Backbone.View.extend({
			el: $('body'),
			events: {
				'click #delete-assets': 'deleteAssets',
				'change #folders': 'changeFolder'
			},
			deleteAssets: function(){
				
				var ids = [];
				$('input[name^=asset-]:checked').each(function(){
					ids.push(this.value);
				});

				if (ids.length) {
					if (confirm('Are you sure you want to delete the selected ' + ids.length + ' assets?')){
						window.location = this.href + '?assets=' + ids.join(',');
					}
				} else {
					alert('Please select some assets');
				}

				return false;
			},
			changeFolder: function(e){

				var uri = _.template($('#folder-uri-template').html(), { folder: e.target.value });

				window.location = uri;
			}
		});

		return IndexView;
	});

})(this.AppData);
