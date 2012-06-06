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
							'text' => __('Manage pages')
						),
						'admin/pages/add' => array(
							'text' => __('Add page')
						),
					),
					'tags' => array(
						'admin/tags' => array(
							'text' => __('Manage tags'),
						),
						'admin/tags/add' => array(
							'text' => __('Add tag'),
						),
					)
				)
			),
			'#nav-users' => array(
				'text' => __('Users'),
				'groups' => array(
					'users' => array(
						'admin/users' => array(
							'text' => __('Manage users'),
						),
						'admin/users/add' => array(
							'text' => __('Add user'),
						),
					),
					'groups' => array(
						'admin/groups' => array(
							'text' => __('Manage groups'),
						),
						'admin/groups/add' => array(
							'text' => __('Add group'),
						),
					),
					'roles' => array(
						'admin/roles' => array(
							'text' => __('Manage roles'),
						),
						'admin/roles/add' => array(
							'text' => __('Add role'),
						),
					)
				)
			),
			'#nav-assets' => array(
				'text' => __('Assets'),
				'pages' => array(
					'admin/assets' => array(
						'text' => __('Manage assets')
					),
					'admin/assets/upload' => array(
						'text' => __('Upload assets')
					)
				)
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
