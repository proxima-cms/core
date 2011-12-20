(function(data){

	var path = data.CORPATH + 'assets/media/js/admin/views/folders/';

	data.scripts.push(
		path + 'index.js',
		path + 'edit.js',
		path + 'add.js'
	);

	require(data.scripts, function(_, Backbone, App, IndexView, EditView, AddView){

		var Routes = Backbone.Router.extend({
			routes: {
				'admin/assets/folders': 'index',
				'admin/assets/folders/:id': 'edit',
				'admin/assets/folders': 'add',
			},
			index: function(){
				new IndexView;
			},
			edit: function(id){
				new EditView;
			},
			add: function(){
				new AddView;
			}
		});

		$(function(){
			(new App).route(Routes);
		});
	});

})(this.AppData);
