<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'styles' => Core::path(array(
		'admin/media/js/libs/jquery-ui/css/smoothness/jquery-ui-1.8.16.custom.css',
		'admin/media/css/jquery.ui.theme.admin.css',
		'admin/media/css/admin.css',
	)),
	'scripts' => Core::path(array(
		'admin/media/js/libs/jquery/jquery-min.js',
		'admin/media/js/libs/underscore/underscore-min.js',
		'admin/media/js/libs/backbone/backbone-min.js',
		'admin/media/js/libs/jquery-ui/js/jquery-ui-1.8.16.custom.min.js',
		'admin/media/js/libs/jquery-ui-selectmenu/jquery.ui.selectmenu.js',
		'admin/media/js/libs/jquery-tree/js/jquery.tree.js',
		'admin/media/js/ui.js',
		'admin/media/js/main.js',
		'admin/media/js/app.js',
	)),
	'paths' => array(
		'base'             => 'admin',
		'tinymce_skin'     => Core::path('admin/media/js/libs/tinymce/jscripts/tiny_mce/themes/advanced/skins/cirkuit/ui.css'),
		'tinymce'          => Core::path('admin/media/js/libs/tinymce/jscripts/tiny_mce/tiny_mce.js'),
		'tinymce_popup'    => Core::path('admin/media/js/libs/tinymce/jscripts/tiny_mce/tiny_mce_popup.js'),
		'tinymce_jquery'   => Core::path('admin/media/js/libs/tinymce/jscripts/tiny_mce/jquery.tinymce.js'),
		'tinymce_init'     => Core::path('admin/media/js/wysiwyg.init.js', FALSE),
		'tinymce_config'   => Core::path('admin/media/js/wysiwyg.config.js', FALSE)
	)		
);
