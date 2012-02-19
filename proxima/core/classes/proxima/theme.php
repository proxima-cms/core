<?php defined('SYSPATH') or die('No direct script access.');

abstract class Proxima_Theme {

	public static $config = array();

	public static $theme_name = 'badsyntax';

	public static $view_path;

	/**
	 * Returns the application path for a theme file.
	 *
	 * @param   mixed   $file   File name
	 * @param   bool    $root		Add the root application path?
	 * @return	string  $path   The file path
	 */
	public static function path($file = NULL, $root = FALSE, $theme = NULL)
	{
		if ($theme === NULL)
		{
			$theme = self::$theme_name;
		}

		$path = "themes/{$theme}/{$file}";

		if ($root !== FALSE)
		{
			$path = self::$view_path.$path;
		}

		return $path;
	}

	/**
	 * Returns a theme view.
	 *
	 * @param   mixed   $file   File name
	 * @param   bool    $root		Add the root application path?
	 * @return	string  $path   The file path
	 */
	public static function view($file = NULL, $root = FALSE, $theme = NULL)
	{
		return View::factory(self::path($file, $root, $theme));
	}

	/**
	 * Returns the root application style path for a css file.
	 *
	 * @param   mixed   $file   Stylesheet file name
	 * @return	string  The stylsheet file path
	 */
	public static function style_path($file = NULL)
	{
		return self::path('media/css/'.$file, TRUE);
	}

	/**
	 * Returns the root application script path for a script file.
	 *
	 * @param   mixed   $file   Script file name
	 * @return	string  The script file path
	 */
	public static function script_path($file = NULL)
	{
		return self::path('media/js/'.$file, TRUE);
	}

	/**
	 * Gets, sets and returns the theme config for a given config group.
	 *
	 * @param   mixed   $group   The group name
	 * @return	mixed  Either null, or the group config array
	 */
	public static function config($group = NULL)
	{
		if ($group === NULL)
		{
			return NULL;
		}

		if (strpos($group, '.') !== FALSE)
		{

			list($group, $path) = explode('.', $group, 2);
		}

		if (!isset(self::$config[$group]))
		{
			self::$config[$group] = require Kohana::find_file('themes', 'badsyntax/config/' . $group);
		}

		if (isset($path))
		{
			return self::$config[$group][$path];
		}
		else
		{
			return self::$config[$group];
		}
	}

}

// Set the view path.
Proxima_Theme::$view_path = str_replace(DOCROOT, '', APPPATH.'views').'/';
