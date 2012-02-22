<?php defined('SYSPATH') or die('No direct access allowed.');

/*
 * Asset routes
 */
// Admin media
Route::set('admin/media', 'admin/media(/<file>)', array('file' => '.+'))
	->defaults(array(
		'controller' 	=> 'media',
		'directory'	=> 'admin',
		'file'       	=> NULL,
	));

// Admin Assets - get asset
Route::set('admin/get-asset', 'admin/assets/get_asset(/<id>)(/<width>)(/<height>)(/<crop>)')
	->defaults(array(
		'action' 	=> 'get_asset',
		'directory' 	=> 'admin',
		'controller' 	=> 'assets'
	));

// Admin Assets - get image url
Route::set('admin/get-asset', 'admin/assets/get_image_url/(<id>)(/<width>)(/<height>)')
	->defaults(array(
		'action' 		 => 'get_image_url',
		'directory'  => 'admin',
		'controller' => 'assets'
	));

// Global media assets
Route::set('media/assets', 'media/assets/<filename>', array(
		'filename' => '.+'
	))
	->defaults(array());

// Global media resized assets
Route::set('media/assets/resized', 'media/assets/resized/<id>_<width>_<height>_<crop>_<filename>', array(
		'id'       => '\d+',
		'width'    => '\d+',
		'height'   => '\d+',
		'crop'     => '\d+',
		'filename' => '.+'
	))
	->defaults(array(
		'directory'	=> 'admin',
		'controller'	=> 'assets',
		'action'	=> 'get_asset',
		'id'		=> 0,
		'height'	=> NULL,
		'crop'		=> NULL,
		'filename'	=> NULL,
	));

// Admin Assets - folders
Route::set('admin/assets-folders', 'admin/assets/folders(/<action>)(/<id>)')
	->defaults(array(
		'controller'  => 'folders',
		'directory'   => 'admin/assets',
	));

// Admin popup assets
Route::set('admin/popup-assets', 'admin/assets/popup(/<action>)(/<id>)')
	->defaults(array(
		'controller' 	=> 'popup',
		'directory' 	=> 'admin/assets',
		'action'      => 'index',
	));

/*
 * Modules routes
 */
Route::set('admin/modules', 'admin/modules(/<action>)(/<module>)')
	->defaults(array(
		'controller' => 'modules',
		'directory'  => 'admin',
		'action'     => 'index',
		'module'     => NULL,
	));

/*
 * Pages routes
 */
Route::set('admin/pages-types', 'admin/pages/types(/<action>)(/<id>)')
	->defaults(array(
		'controller'  => 'pages_types',
		'directory'   => 'admin',
	));

/*
 * Tags routes
 */
Route::set('admin/tag-delete', 'admin/tags/delete/<id>', array('id' => '.*'))
	->defaults(array(
		'action'    => 'delete',
		'directory'   => 'admin',
		'controller'  => 'tags'
	));

// Error page
Route::set('error', 'error/<action>(/<message>)', array('action' => '[0-9]++', 'message' => '.+'))
	->defaults(array(
		'controller' => 'error'
	));

// Admin config
Route::set('admin/config', 'admin/config(/<group>)')
	->defaults(array(
		'controller' => 'config',
		'directory'  => 'admin',
		'action'     => 'index',
		'group'      => NULL,
	));

// Admin logs
Route::set('admin/logs/download', 'admin/logs/download(/<format>)')
	->defaults(array(
		'controller' => 'logs',
		'directory'  => 'admin',
		'action'     => 'download',
		'format'     => NULL
	));
Route::set('admin/logs', 'admin/logs(/<file>)', array('file' => '.+'))
	->defaults(array(
		'controller' => 'logs',
		'directory'  => 'admin',
		'action'     => 'index',
		'file'       => NULL
	));

// Set the install route
Route::set('install', 'install(/<action>)')
	->defaults(array(
		'controller' => 'install',
		'action' => 'index',
));

/*
 * Admin routes
 */
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
->defaults(array(
	'action'     => 'index',
	'directory'  => 'admin',
	'controller' => 'home'
));

/*
 * Component routes
 */
Route::set('component', 'component(/<controller>(/<action>(/<id>)))')
->defaults(array(
	'action'     => 'index',
	'directory'  => 'component',
	'uri'        => '' // This sets the page model to be the home page
));


// Find all pages that require routing to specific controllers
$route_pages = ORM::factory('site_page')
	->where('pagetype_controller', '<>', 'page')
	->and_where('pagetype_controller', 'IS NOT', NULL)
	->find_all();

foreach($route_pages as $page)
{
	// Set the page route
	Route::set($page->uri, $page->uri.'(/<param>)', array('param' => '.*'))
		->defaults(array(
			'controller' => $page->pagetype_controller,
			'action'     => 'index',
			'uri'        => $page->uri,
		));
}

// Set the 'catch all' route
Route::set('page', '<uri>', array('uri' => '.*'))
	->defaults(array(
		'controller' => 'page',
		'action'     => 'index'
	));