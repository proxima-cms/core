<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'paths' => array(
		'tinymce_skin'     => Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/themes/advanced/skins/cirkuit/ui.css'),
		'tinymce'          => Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/tiny_mce.js'),
		'tinymce_popup'    => Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/tiny_mce_popup.js'),
		'tinymce_jquery'   => Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/jquery.tinymce.js'),
		'tinymce_init'     => Core::media('js/admin/wysiwyg.init.js', FALSE),
		'tinymce_config'   => Core::media('js/admin/wysiwyg.config.js', FALSE)
	)
);
