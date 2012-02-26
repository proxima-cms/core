<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'master' => array(
		array('script', Core::media('js/admin/pages/pages.js'), 'head', 12),
	),
	'edit' => array(
		array('style', Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/themes/advanced/skins/cirkuit/ui.css'), 'head', 13),
		array('script', Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/jquery.tinymce.js'), 'head', 14),
		array('script', Core::media('js/admin/wysiwyg.config.js', FALSE), 'head', 15),
	),
	'add' => array(
		array('style', Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/themes/advanced/skins/cirkuit/ui.css'), 'head', 13),
		array('script', Core::media('js/admin/libs/tinymce/jscripts/tiny_mce/jquery.tinymce.js'), 'head', 14),
		array('script', Core::media('js/admin/wysiwyg.config.js', FALSE), 'head', 15),
	)
);
