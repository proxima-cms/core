<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Core {

	/**
	* Core init: enable system modules, check paths exist and set the database config reader.
	* This function is called once within bootstrap.php
	*
	* @return  void
	*/
	public static function init()
	{
		// Check system paths exist.
		self::check_paths();

		// Set module default config.
		Cache::$default = 'apc';
		Image::$default_driver = 'imagick';
		Cookie::$salt = 'proxima-cms';

		// Attach the database config reader.
		Kohana::$config->attach(new Config_Database);

		// Set the application routes.
		self::set_routes();
	}

	/**
	* Check system paths exist.
	*
	* @return  void
	*/
	public static function check_paths()
	{
		if (!is_dir(DOCROOT . 'media'))
		{
			throw new Kohana_Exception('Directory :dir does not exist',
				array(':dir' => Debug::path('media')));
		}
		if (!is_dir(DOCROOT . 'media/assets'))
		{
			throw new Kohana_Exception('Directory :dir does not exist',
				array(':dir' => Debug::path('media/assets')));
		}
		if (!is_dir(DOCROOT . 'media/assets/resized'))
		{
			throw new Kohana_Exception('Directory :dir does not exist',
				array(':dir' => Debug::path('media/assets/resized')));
		}
		if (!is_dir(DOCROOT . 'media/cache'))
		{
			throw new Kohana_Exception('Directory :dir does not exist',
				array(':dir' => Debug::path('media/cache')));
		}
		if (! is_writable(DOCROOT . 'media/cache'))
		{
			throw new Kohana_Exception('Directory :dir must be writable',
				array(':dir' => Debug::path('../media/cache')));
		}
		if (! is_writable(DOCROOT . 'media/assets/resized'))
		{
			throw new Kohana_Exception('Directory :dir must be writable',
				array(':dir' => Debug::path('../media/assets/resized')));
		}
	}

	/** 
	 * Returns the core module path for a given file.
	 *
	 * @param		mixed		$file		File name
	 * @param		bool		$root		Add the root application path?
	 * @return	string	$path		The file path
	 */
	public static function path($file = NULL, $root = TRUE)
	{
		$root = $root === TRUE ? str_replace(DOCROOT, '', CORPATH) : '';

		if (is_array($file))
		{
			$files = array();

			foreach($file as $f)
			{
				$files[] = $root . $f;
			}

			return $files;
		}
		
		return $root . $file;
	}
	
	/**
	* Set the application routes.
	*
	* @return  void
	*/
	public static function set_routes()
	{
		if ( ! Route::cache())
		{
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
			Route::set('admin/logs', 'admin/logs(/<file>)', array('file' => '.+'))
				->defaults(array(
					'controller' => 'admin_logs',
					'action'     => 'index',	
					'file'       => NULL
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

			Route::cache(TRUE);
		}
	}
}
