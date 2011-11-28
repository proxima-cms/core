<?php

class Core {

	/**
	* Core init: enable system modules, check paths exist and set the database config reader.
	*
	* @return  void
	*/
	public static function init()
	{
		// Check system paths exist.
		self::check_paths();

		// Attach the database config reader.
		Kohana::$config->attach(new Config_Database);
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
		/**
		* Set the routes. Each route must have a minimum of a name, a URI and a set of
		* defaults for the URI.
		*/
		Route::set('default', '(<controller>(/<action>(/<id>)))')
			->defaults(array(
				'controller' => 'welcome',
				'action'     => 'index',
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
				'action'		 => 'index',
				'group'			 => NULL,
			));

		// Admin logs
		Route::set('admin/logs', 'admin/logs(/<file>)', array('file' => '.+'))
			->defaults(array(
				'controller' => 'admin_logs',
				'action'		 => 'index',	
				'file'			 => NULL
			));

		// Find all pages that require routing to specific controllers.
		$route_pages = ORM::factory('site_page')
			->where('pagetype_controller', '<>', 'page')
			->and_where('pagetype_controller', 'IS NOT', NULL)
			->find_all();

		foreach($route_pages as $page)
		{
			// Set the page route.
			Route::set($page->uri, $page->uri.'(/<param>)', array('param' => '.*'))
				->defaults(array(
					'controller' => $page->pagetype_controller,
					'action'		 => 'index',
					'uri'				 => $page->uri,
				));
		}
			
		// Set the 'catch all' route.
		Route::set('page', '<uri>', array('uri' => '.*'))
			->defaults(array(
				'controller' => 'page',
				'action'		 => 'index'
			));
	}
}
