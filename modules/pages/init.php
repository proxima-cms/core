<?php defined('SYSPATH') or die('No direct script access.');

	Route::set('admin/pages-types', 'admin/pages/types(/<action>(/<id>))')
		->defaults(array(
			'controller'  => 'types',
			'directory' => 'admin/pages'
	));
