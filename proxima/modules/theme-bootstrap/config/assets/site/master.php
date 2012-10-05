<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'page' => array(
    array('style', Proxima::media('css/bootstrap.min.css', 'bootstrap'), 'head', 1),
		array('style', Proxima::media('css/bootstrap-responsive.min.css', 'bootstrap'), 'head', 2),
		array('script', Proxima::media('js/jquery-1.8.2.min.js', 'bootstrap'), 'head', 2),
		array('script', Proxima::media('js/bootstrap.min.js', 'bootstrap'), 'body', 1),
	),
);
