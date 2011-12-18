<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'styles' => Core::path(array(
		'admin/media/js/libs/jquery-ui/css/smoothness/jquery-ui-1.8.16.custom.css',
		'admin/media/css/jquery.ui.theme.admin.css',
		'admin/media/css/admin.css',
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
