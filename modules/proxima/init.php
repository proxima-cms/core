<?php defined('SYSPATH') or die('No direct script access.');

Core::init();

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
		'action' 		=> 'get_image_url',
		'directory' 	=> 'admin',
		'controller' 	=> 'assets'
	));

// Global media assets
Route::set('media/assets', 'media/assets/resized/(<id>_<width>_<height>_<crop>_<filename>)', array(
		'id' 		=> '\d+',
		'width' 	=> '\d+',
		'height'	=> '\d+',
		'crop'		=> '\d+',
		'filename'	=> '.+'
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
		'controller'  => 'assets_folders',
		'directory'   => 'admin',
	)); 
	
// Admin popup assets
Route::set('admin/popup-assets', 'admin/assets/popup(/<action>)(/<id>)')
	->defaults(array(
		'controller' 	=> 'assets_popup',
		'directory' 	=> 'admin',
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

/*
 * Site routes 
 */
Core::set_routes();
