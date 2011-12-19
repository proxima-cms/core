(function(data){

	var path = data.CORPATH + 'blogimport/media/js/admin/views/';

	data.scripts.push(
		path + 'index.js'
	);

	require(data.scripts, function(_, Backbone, App, IndexView, EditView, AddView){

		var Routes = Backbone.Router.extend({
			routes: {
				'admin/blogimport': 'index'
			},
			index: function(){
				new IndexView;
			}
		});

		$(function(){
			(new App).route(Routes);
		});
	});

})(this.AppData);
