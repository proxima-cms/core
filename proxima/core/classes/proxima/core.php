<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Core {

	/**
	 * @var  string  True if Proxima is installed
	 */
	public static $is_installed = TRUE;

	/**
	* Core system init: application config and setup.
	* This function is called once within bootstrap.php
	*
	* @return  void
	*/
	public static function init()
	{
		// Run a check to see if Proxima is installed.
		// We probably want to handle this in a config file!
		self::$is_installed = (bool) Database::instance()->query(Database::SELECT, 'SHOW TABLES LIKE "users"')->count();

		// Set default config
		Cache::$default = Kohana::$config->load('default.cache.driver');
		Image::$default_driver = Kohana::$config->load('default.image.driver');
		Cookie::$salt = Kohana::$config->load('default.cookie.salt');

		if ( !Kohana::$is_cli )
		{
			if (Proxima::$is_installed)
			{
				// Attach the database config reader.
				Kohana::$config->attach(new Config_Database);

				if ( ! Route::cache())
				{
					// Set the core application routes
					include_once CORPATH.'config/routes'.EXT;
				}
			}
			else
			{
				// Set the install route
				Route::set('install', 'install(/<action>)')
					->defaults(array(
						'controller' => 'install',
						'action' => 'index',
				));
			}

			// Create the main request site request
			$request = Request::factory();

			// Allowed install controllers
			$install_controller = in_array($request->controller(), array('install', 'media'));

			$can_install = (bool) Kohana::$config->load('install.can_install_uninstall');

			// Check if we need to install
			if ( (!Proxima::$is_installed AND !$install_controller) OR ($can_install AND !$install_controller) )
			{
				$request->redirect('install?return_to='.$request->uri());
			}
		}
		else
		{
			// Create the CLI request
			$request = Request::factory();
		}

		/**
		 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
		 * If no source is specified, the URI will be automatically detected.
		 */
		echo $request->execute()->send_headers()->body();
	}

	/**
	 * Returns the core media path for a given file.
	 *
	 * @param		mixed		$file		File name
	 * @param		bool		$root		Add the root application path?
	 * @return	mixed   $paths
	 */
	public static function media($file = NULL, $root = 'proxima')
	{
		$root .= '/';

		// If we have an array of media files
		if (is_array($file))
		{
			$files = array();

			foreach($file as $f)
			{
				$files[] = Media::uri($root.$f);
			}

			return $files;
		}

		return Media::uri($root.$file);
	}
}
