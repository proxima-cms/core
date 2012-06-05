<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'nav' => array(
		'links' => array(
			'admin' => array(
				'text' => __('Dashboard'),
			),
			'#nav-content' => array(
				'text' => __('Content'),
				'groups' => array(
					'pages' => array(
						'admin/pages' => array(
							'text' => __('Manage Pages')
						),
						'admin/pages/add' => array(
							'text' => __('Add Page')
						),
					),
					'tags' => array(
						'admin/tags' => array(
							'text' => __('Manage Tags'),
						),
						'admin/tags/add' => array(
							'text' => __('Add Tag'),
						),
					)
				)
			),
			'#nav-users' => array(
				'text' => __('Users'),
				'groups' => array(
					'users' => array(
						'admin/users' => array(
							'text' => __('Manage Users'),
						),
						'admin/users/add' => array(
							'text' => __('Add User'),
						),
					),
					'groups' => array(
						'admin/groups' => array(
							'text' => __('Manage Groups'),
						),
						'admin/groups/add' => array(
							'text' => __('Add Group'),
						),
					),
					'roles' => array(
						'admin/roles' => array(
							'text' => __('Manage Roles'),
						)
					)
				)
			),
			'admin/assets' => array(
				'text' => __('Assets')
			),
			'admin/config' => array(
				'text' => __('Config'),
			),
			'#nav-maintenance' => array(
				'text' => __('Maintenance'),
				'pages' => array(
					'admin/logs' => array(
						'text' => __('Logs'),
					),
					'admin/cache' => array(
						'text' => __('Cache'),
					),
					'admin/redirects' => array(
						'text' => __('Redirects'),
					),
					'admin/components' => array(
						'text' => __('Components'),
					),
				)
			),
			'admin/modules' => array(
				'text' => __('Modules'),
			),
		)
	)
);
