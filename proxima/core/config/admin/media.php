<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'paths' => array(
		'tinymce_skin'     => Proxima::media('js/admin/libs/tinymce/jscripts/tiny_mce/themes/advanced/skins/cirkuit/ui.css'),
		'tinymce'          => Proxima::media('js/admin/libs/tinymce/jscripts/tiny_mce/tiny_mce.js'),
		'tinymce_popup'    => Proxima::media('js/admin/libs/tinymce/jscripts/tiny_mce/tiny_mce_popup.js'),
		'tinymce_jquery'   => Proxima::media('js/admin/libs/tinymce/jscripts/tiny_mce/jquery.tinymce.js'),
		'tinymce_init'     => Proxima::media('js/admin/wysiwyg.init.js', FALSE),
		'tinymce_config'   => Proxima::media('js/admin/wysiwyg.config.js', FALSE)
	)
);
