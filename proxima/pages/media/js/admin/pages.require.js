(function(data){

	var path = data.CORPATH + 'pages/media/js/admin/views/';

	data.scripts.push(
		path + 'index.js',
		path + 'edit.js',
		path + 'add.js'
	);

	require(data.scripts, function(_, Backbone, App, IndexView, EditView, AddView){

		var Pages = Backbone.Router.extend({
			routes: {
				'admin/pages': 'index',
				'admin/pages/edit/:id': 'edit',
				'admin/pages/add': 'add',
			},
			index: function(){
				new IndexView;
			},
			edit: function(id){
				new EditView;
			},
			add: function(id){
				new AddView;
			}
		});

		$(function(){
			(new App).route(Pages);
		});
	});

})(this.AppData);
