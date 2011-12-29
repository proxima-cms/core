<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'styles' => Core::path(array(
		'media/js/admin/libs/jquery-ui/css/smoothness/jquery-ui-1.8.16.custom.css',
		'media/css/admin/jquery.ui.theme.admin.css',
		'media/css/admin/admin.css',
	)),
	'scripts' => Core::path(array(
		'media/js/admin/libs/jquery/jquery-min.js',
		'media/js/admin/libs/underscore/underscore-min.js',
		'media/js/admin/libs/backbone/backbone-min.js',
		'media/js/admin/libs/jquery-ui/js/jquery-ui-1.8.16.custom.min.js',
		'media/js/admin/libs/jquery-ui-selectmenu/jquery.ui.selectmenu.js',
		'media/js/admin/libs/jquery-tree/js/jquery.tree.js',
		'media/js/admin/ui.js',
		'media/js/admin/main.js',
		'media/js/admin/app.js',
	)),
	'paths' => array(
		'base'             => 'admin',
		'tinymce_skin'     => Core::path('media/js/admin/libs/tinymce/jscripts/tiny_mce/themes/advanced/skins/cirkuit/ui.css'),
		'tinymce'          => Core::path('media/js/admin/libs/tinymce/jscripts/tiny_mce/tiny_mce.js'),
		'tinymce_popup'    => Core::path('media/js/admin/libs/tinymce/jscripts/tiny_mce/tiny_mce_popup.js'),
		'tinymce_jquery'   => Core::path('media/js/admin/libs/tinymce/jscripts/tiny_mce/jquery.tinymce.js'),
		'tinymce_init'     => Core::path('media/js/admin/wysiwyg.init.js', FALSE),
		'tinymce_config'   => Core::path('media/js/admin/wysiwyg.config.js', FALSE)
	)		
);
