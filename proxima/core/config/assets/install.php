<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'page' => array(
		array('style', Core::media('css/install/install.css'), 'head', 0),
		array('script', Core::media('js/libs/jquery/jquery-min.js'), 'head', 1),
		array('script', Core::media('js/install/install.js'), 'body', 10),
	)
);