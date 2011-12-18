define([
	'jquery',
	'underscore',
	'backbone',
], function($, _, Backbone){

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

	return EditView;
});
