<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'page' => array(
		array('style', Proxima::media('css/screen.css', 'badsyntax'), 'head', 0),
		array('script', Proxima::media('js/libs/jquery/jquery-min.js', 'badsyntax'), 'head', 1),
		array('script', Proxima::media('js/global.js', 'badsyntax'), 'body', 10),
	),
);
