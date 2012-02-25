<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'master' => array(
		array('style', Core::media('css/admin/admin.global.css'), 'head', 0),
		array('script', Core::media('js/libs/jquery/jquery-min.js'), 'head', 1),
		array('script', Core::media('js/libs/jquery-ui/js/jquery-ui-1.8.16.custom.min.js'), 'head', 2),
		array('script', Core::media('js/admin/libs/underscore/underscore-min.js'), 'head', 3),
		array('script', Core::media('js/admin/libs/backbone/backbone-min.js'), 'head', 4),
		array('script', Core::media('js/admin/libs/jquery-ui-selectmenu/jquery.ui.selectmenu.js'), 'head', 5),
		array('script', Core::media('js/admin/libs/jquery-tree/js/jquery.tree.js'), 'head', 6),
		array('script', Core::media('js/admin/ui.js'), 'head', 7),
		array('script', Core::media('js/admin/main.js'), 'head', 8),
		array('script', Core::media('js/admin/app.js'), 'head', 9),
	)
);