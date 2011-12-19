define([
	'jquery',
	'underscore',
	'backbone',
], function($, _, Backbone){

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

	return UploadView;
});
