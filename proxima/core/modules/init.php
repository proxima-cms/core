<?php defined('SYSPATH') or die('No direct script access.');

// Modules config
Route::set('admin/modules', 'admin/modules(/<action>)(/<module>)')
	->defaults(array(
		'controller' => 'modules',
		'directory'  => 'admin',
		'action'     => 'index',
		'module'     => NULL,
	));
