require.config({
		baseUrl: "/proxima/core/admin/media/js",
		paths: {
				'jquery': 'libs/jquery/jquery-min',
				'underscore': 'libs/underscore/underscore-min', 
				'backbone': 'libs/backbone/backbone', // AMD support
		}
});

require([
		'jquery',
		'underscore',
		'backbone',
], function($, _, Backbone, App){
	$(function(){
			//App.initialize();
	});
});
