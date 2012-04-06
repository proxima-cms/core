<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'master' => array(
		array('style', Proxima::media('css/admin/admin.global.css'), 'head', 0),
		array('style', Proxima::media('css/admin/jquery.ui.theme.admin.css'), 'head', 1),
		array('style', Proxima::media('js/libs/jquery-ui/css/smoothness/jquery-ui-1.8.16.custom.css'), 'head', 1),
		array('script', Proxima::media('js/libs/jquery/jquery-min.js'), 'head', 2),
		array('script', Proxima::media('js/libs/jquery-ui/js/jquery-ui-1.8.16.custom.min.js'), 'head', 3),
		array('script', Proxima::media('js/admin/libs/underscore/underscore-min.js'), 'head', 4),
		array('script', Proxima::media('js/admin/libs/backbone/backbone-min.js'), 'head', 5),
		array('script', Proxima::media('js/admin/libs/jquery-ui-selectmenu/jquery.ui.selectmenu.js'), 'head', 6),
		array('script', Proxima::media('js/admin/libs/jquery-tree/js/jquery.tree.js'), 'head', 7),
		array('script', Proxima::media('js/admin/ui.js'), 'head', 8),
		array('script', Proxima::media('js/admin/main.js'), 'head', 9),
		array('script', Proxima::media('js/admin/app.js'), 'head', 10),
	)
);