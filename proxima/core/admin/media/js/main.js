(function(data){

	require.config({
		baseUrl: data.CORPATH + "admin/media/js",
		paths: {
			'underscore': 'libs/underscore/underscore-min', 
			'backbone': 'libs/backbone/backbone-min',
			'app': 'app'
		}
	});

})(this.AppData);
