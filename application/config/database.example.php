<?php defined('SYSPATH') or die('No direct access allowed.');

return array(
	'default' => array(
		'type'			 => 'mysql',
		'connection' => array(
			'hostname'	 => 'localhost',
			'username'	 => 'root',
			'password'	 => '',
			'persistent' => FALSE,
			'database'	 => 'blog.badsyntax.co_dev',
		),
		'table_prefix' => '',
		'charset'			 => 'utf8',
		'caching'			 => FALSE,
		'profiling'		 => TRUE,
	)
);
