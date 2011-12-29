<?php defined('SYSPATH') or die('No direct script access.');
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

