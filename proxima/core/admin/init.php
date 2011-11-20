<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Admin routes 
 */

// Admin controllers
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'action'     => 'index',
		'directory'  => 'admin',
		'controller' => 'home'
	));
