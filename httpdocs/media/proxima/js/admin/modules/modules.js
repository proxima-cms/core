(function(data){

	var path = data.CORPATH + 'modules/media/js/admin/views/';

	data.scripts.push(
		path + 'index.js'
	);

	require(data.scripts, function(_, Backbone, App, IndexView, EditView, AddView){

		var Users = Backbone.Router.extend({
			routes: {
				'admin/modules': 'index',
			},
			index: function(){
				new IndexView;
			}
		});

		$(function(){
			(new App).route(Users);
		});
	});

})(this.AppData);
