<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'styles' => Core::path(array(
		'admin/media/js/jquery-ui/build/dist/jquery-ui-1.9pre/themes/base/jquery-ui.css',
		'admin/media/css/jquery.ui.theme.admin.css',
		'admin/media/css/admin.css',
	)),
	'scripts' => Core::path(array(
		'admin/media/js/jquery.min.js',
		'admin/media/js/jquery-ui/build/dist/jquery-ui-1.9pre/ui/jquery-ui.js',
		'admin/media/js/jquery.ui.selectmenu.js',
		'admin/media/js/jquery-tree/js/jquery.tree.js',
		'admin/media/js/require.js',
		'admin/media/js/admin.js',
		'admin/media/js/admin.util.js',
	)),
	'paths' => array(
		'base'             => 'admin',
		'tinymce_skin'     => Core::path('admin/media/js/tinymce/jscripts/tiny_mce/themes/advanced/skins/cirkuit/ui.css'),
		'tinymce'          => Core::path('admin/media/js/tinymce/jscripts/tiny_mce/tiny_mce.js'),
		'tinymce_popup'    => Core::path('admin/media/js/tinymce/jscripts/tiny_mce/tiny_mce_popup.js'),
		'tinymce_jquery'   => Core::path('admin/media/js/tinymce/jscripts/tiny_mce/jquery.tinymce.js'),
		'tinymce_init'     => Core::path('admin/media/js/wysiwyg.init.js', FALSE),
		'tinymce_config'   => Core::path('admin/media/js/wysiwyg.config.js', FALSE)
	)		
);
