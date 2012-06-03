<?php defined('SYSPATH') or die('No direct script access.');

/*
 * Auto generated on: Sunday 3rd of June 2012 01:42:09 AM
 * Notes: Change the default admin navigation links in config/admin/default.php
 */

return array(
	'links' => array(
		'admin' => array(
			'text' => __('Dashboard')
		),
		'#nav-content' => array(
			'text' => __('Content'),
			'pages' => array(
				'admin/pages' => array(
					'text' => __('Pages')
				),
				'admin/tags' => array(
					'text' => __('Tags')
				),
			),
		),
		'#nav-users' => array(
			'text' => __('Users'),
			'pages' => array(
				'admin/users' => array(
					'text' => __('Users')
				),
				'admin/groups' => array(
					'text' => __('Groups')
				),
				'admin/roles' => array(
					'text' => __('Roles')
				),
			),
		),
		'admin/assets' => array(
			'text' => __('Assets')
		),
		'admin/config' => array(
			'text' => __('Config')
		),
		'#nav-maintenance' => array(
			'text' => __('Maintenance'),
			'pages' => array(
				'admin/logs' => array(
					'text' => __('Logs')
				),
				'admin/cache' => array(
					'text' => __('Cache')
				),
				'admin/redirects' => array(
					'text' => __('Redirects')
				),
				'admin/components' => array(
					'text' => __('Components')
				),
			),
		),
		'admin/modules' => array(
			'text' => __('Modules')
		),
		'admin/blogimport' => array(
			'text' => __('Blog import')
		),
	)
);