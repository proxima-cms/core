<?php defined('SYSPATH') or die('No direct access allowed.');

return 
	Kohana::$environment == Kohana::PRODUCTION
	/* PRODUCTION database */
	? array
	(
		'default' => array
		(
			'type'			 => 'mysql',
			'connection' => array(
				'hostname'	 => 'localhost',
				'username'	 => 'root',
				'password'	 => 'dec1ph3r',
				'persistent' => FALSE,
				'database'	 => 'blog.badsyntax.co_live',
			),
			'table_prefix' => '',
			'charset'			 => 'utf8',
			'caching'			 => FALSE,
			'profiling'		 => TRUE,
		)
	)
	/* DEVELOPMENT database */
	: array
	(
		'default' => array
		(
			'type'			 => 'mysql',
			'connection' => array(
				'hostname'	 => 'localhost',
				'username'	 => 'root',
				'password'	 => 'dec1ph3r',
				'persistent' => FALSE,
				'database'	 => 'blog.badsyntax.co_dev',
			),
			'table_prefix' => '',
			'charset'			 => 'utf8',
			'caching'			 => FALSE,
			'profiling'		 => TRUE,
		)
	);

