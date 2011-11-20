<?php

class Core {

	/**
	* Core init: enable system modules, check paths exist and set the database config reader.
	*
	* @return  void
	*/
	public static function init()
	{
		// Enable system modules.
		Kohana::modules(Kohana::$config->load('modules')->as_array());

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
	* Set the application routes.
	*
	* @return  void
	*/
	public static function set_routes()
	{
		// Set the error page route.
		Route::set('error', 'error/<action>(/<message>)', array('action' => '[0-9]++', 'message' => '.+'))
			->defaults(array(
				'controller' => 'error'
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
