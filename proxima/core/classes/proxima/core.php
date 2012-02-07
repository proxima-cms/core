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
		Cache::$default = 'apc';
		Image::$default_driver = 'imagick';
		Cookie::$salt = 'JpTKsYl8bqjJdsNbHKqg';

		// If Proxima is not installed, and we're not viewing an install page, then redirect to the installer
		if ( !Kohana::$is_cli AND !Core::$is_installed AND !preg_match('/^\/install|media(\/.*?)?$/', Request::detect_uri()) )
		{
			Request::factory('install')->redirect('install');
		}

		if ( ! Kohana::$is_cli)
		{
			if (Core::$is_installed)
			{
				// Attach the database config reader.
				Kohana::$config->attach(new Config_Database);

				if ( ! Route::cache())
				{
					// Set the core application routes
					include CORPATH.'config/routes'.EXT;
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
		}
	}

	/**
	 * Returns the core media path for a given file.
	 *
	 * @param		mixed		$file		File name
	 * @param		bool		$root		Add the root application path?
	 * @return	string	$path		The file path
	 */
	public static function media($file = NULL)
	{
		$root = 'proxima/';

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
