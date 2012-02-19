<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'page' => array(
		array('style', Core::media('css/screen.css', 'badsyntax'), 'head', 0),
		array('script', Core::media('js/libs/jquery/jquery-min.js', 'badsyntax'), 'head', 1),
		array('script', Core::media('js/global.js', 'badsyntax'), 'body', 10),
	),
);
