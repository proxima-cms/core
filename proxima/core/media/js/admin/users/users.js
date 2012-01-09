(function(data){

	var path = data.CORPATH + 'users/media/js/admin/views/';

	data.scripts.push(
		path + 'index.js',
		path + 'edit.js',
		path + 'add.js'
	);

	require(data.scripts, function(_, Backbone, App, IndexView, EditView, AddView){

		var Users = Backbone.Router.extend({
			routes: {
				'admin/users': 'index',
				'admin/users/edit/:id': 'edit',
				'admin/users/add': 'add',
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
			(new App).route(Users);
		});
	});

})(this.AppData);
