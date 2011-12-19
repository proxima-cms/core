(function(data){

	define([
		'underscore',
		'backbone'
	], function(_, Backbone, Pages){

		var IndexView = Backbone.View.extend({
			el: $('body'),
			events: {
				'click #delete-tags': 'deleteTags'
			},
			initialize: function(){

			},
			deleteTags: function(e){

				e.preventDefault();

				var tags = $('input[type=checkbox][name^=tag]:checked');

				if (!tags.length) {

					alert('Please select some tags to delete.');

				} else {

					var url = '/admin/tags/delete/' + $.map(tags, function(elem){
						return elem.id.replace(/^tag-/, '');
					}).join(',');

					window.location = url;
				}
			}
		});

		return IndexView;
	});

})(this.AppData);
