<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'styles' => Core::media(array(
		//'js/libs/jquery-ui/css/smoothness/jquery-ui-1.8.16.custom.css',
		//'css/admin/jquery.ui.theme.admin.css',
		'css/admin/admin.global.css',
	)),
	'scripts' => Core::media(array(
		'js/libs/jquery/jquery-min.js',
		'js/libs/jquery-ui/js/jquery-ui-1.8.16.custom.min.js',
		'js/admin/libs/underscore/underscore-min.js',
		'js/admin/libs/backbone/backbone-min.js',
		'js/admin/libs/jquery-ui-selectmenu/jquery.ui.selectmenu.js',
		'js/admin/libs/jquery-tree/js/jquery.tree.js',
		'js/admin/ui.js',
		'js/admin/main.js',
		'js/admin/app.js',
	)),
	'paths' => array(
		'base'             => 'admin',
		'tinymce_skin'     => Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/themes/advanced/skins/cirkuit/ui.css'),
		'tinymce'          => Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/tiny_mce.js'),
		'tinymce_popup'    => Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/tiny_mce_popup.js'),
		'tinymce_jquery'   => Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/jquery.tinymce.js'),
		'tinymce_init'     => Core::media('js/admin/wysiwyg.init.js', FALSE),
		'tinymce_config'   => Core::media('js/admin/wysiwyg.config.js', FALSE)
	)
);
