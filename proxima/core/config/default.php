<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'modules' => array(
		'assets',
		'minion',
		'minion-tasks-migrations',
		'message',
		'media',
		'image',
		'database',
		'compress',
		'cache',
		'auth',
		'orm',
		'pagination',
		'email',
	),
	'cache' => array(
		'driver' => 'apc',
	),
	'image' => array(
		'driver' => 'imagick',
	),
	'cookie' => array(
		// Change this salt to something unique!
		'salt' => 'JpTKsYl8bqjJdsNbHKqg'
	)
);
