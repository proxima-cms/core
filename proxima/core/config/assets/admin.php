<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'master' => array(
		array('style', Proxima::media('css/admin/global.css'), 'head', 0),
		array('script', Proxima::media('js/admin/libs/jquery/jquery-1.7.2.min.js'), 'body', 1),
		array('script', Proxima::media('js/admin/libs/bootstrap/bootstrap.js'), 'body', 2),
	)
);
