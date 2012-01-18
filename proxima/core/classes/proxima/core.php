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
		try
		{
			ORM::factory('user');
		}
		catch(Database_Exception $e)
		{
			Core::$is_installed = FALSE;
		}

		// Set default config.
		I18n::lang('en-gb');
		Cache::$default = 'apc';
		Image::$default_driver = 'imagick';
		Cookie::$salt = 'JpTKsYl8bqjJdsNbHKqg';

		$installer_urls = array(
			'/install',
			'/install/tests',
			'/install/success'
		);

		// If Proxima is not installed, and we're not viewing
		// an install page, then redirect to the installer.
		if ( !Kohana::$is_cli AND !Core::$is_installed AND !in_array(Request::detect_uri(), $installer_urls))
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
}
