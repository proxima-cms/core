<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'page' => array(
		array('style', Proxima::media('css/install/install.css'), 'head', 0),
		array('script', Proxima::media('js/libs/jquery/jquery-min.js'), 'head', 1),
		array('script', Proxima::media('js/install/install.js'), 'body', 10),
	)
);