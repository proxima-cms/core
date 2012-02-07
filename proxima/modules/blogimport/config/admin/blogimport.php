<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'tumblr' => array(
		'posts' => '%s/api/read?num=50',
		'pages' => '%s/api/pages'
	),
	'scripts' => array(
		Core::media('blogimport/media/js/admin/blogimport.js')
	)
);
