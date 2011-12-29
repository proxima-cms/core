(function($){

	$(function(){
	
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

		var EditView = Backbone.View.extend({
			el: $('body'),
			events: {
				'focusin #filename':  'focusFilename',
				'focusout #filename': 'blurFilename'
			},
			initialize: function(){
			},
			focusFilename: function(e){
				if (!$.data(e.target, 'extension')){

					$.data(e.target, 'extension', e.target.value.replace(/^.*(\..*?)$/, '$1'));
				}           
				e.target.value = e.target.value.replace(new RegExp($.data(e.target, 'extension') + '$'), '');
			},
			blurFilename: function(e){
				e.target.value += $.data(e.target, 'extension');    
			}
		});

		var UploadView = Backbone.View.extend({
			initialize: function(){
				return;
				$('#asset').uploadify({
					uploade: '/modules/admin/media/flash/uploadify.swf',
					script: '/admin/assets/upload',
					cancelImg: '/modules/admin/media/img/uploadify-cancel.png',
					auto: true,
					debug: true,
					fileDataName: 'asset'
				});  	
			}
		});

		var Routes = Backbone.Router.extend({
			routes: {
				'admin/assets': 'index',
				'admin/assets?*params': 'index',
				'admin/assets/edit/:id': 'edit',
				'admin/assets/upload': 'upload',
			},
			index: function(){
				new IndexView;
			},
			edit: function(id){
				new EditView;
			},
			upload: function(){
				new UploadView;
			}
		});

		window.AppRoutes = Routes;

	});

})(this.jQuery);
