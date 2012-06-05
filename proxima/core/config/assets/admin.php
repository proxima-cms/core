<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'master' => array(
		array('style', Proxima::media('css/admin/global.css'), 'head', 0),
		array('script', Proxima::media('js/admin/libs/jquery/jquery-1.7.2.min.js'), 'body', 1),
		array('script', Proxima::media('js/admin/libs/bootstrap/bootstrap.js'), 'body', 2),
		//array('script', Proxima::media('js/admin/libs/backbone/backbone-min.js'), 'body', 3),
		array('script', Proxima::media('js/admin/libs/jquery-bbq/jquery.ba-bbq.min.js'), 'body', 4),
		array('script', Proxima::media('js/admin/global.js'), 'body', 5),
		array('style', Proxima::media('js/admin/libs/tinymce/jscripts/tiny_mce/themes/advanced/skins/cirkuit/ui.css'), 'head', 13),
		array('script', Proxima::media('js/admin/libs/tinymce/jscripts/tiny_mce/tiny_mce.js'), 'body', 14),
		array('script', 'admin/media/js/wysiwyg.config.js', 'body', 15),
		array('script', Proxima::media('js/admin/libs/jquery-ui-bootstrap/js/jquery-ui-1.8.16.custom.min.js'), 'body', 16),
		array('style', Proxima::media('js/admin/libs/jquery-ui-bootstrap/css/custom-theme/jquery-ui-1.8.16.custom.css'), 'head', 14),
	)
);
