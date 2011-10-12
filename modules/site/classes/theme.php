<?php

abstract class Theme {

	public static $config = array();

	public static function path($file = NULL)
	{
		return 'themes/badsyntax/'.$file;
	}

	public static function config($group = NULL)
	{
		if (strpos($group, '.') !== FALSE)
		{
			list ($group, $path) = explode('.', $group, 2);
		}

		if (!isset(self::$config[$group]))
		{
			self::$config[$group] = require Kohana::find_file('views/themes/badsyntax/config', $group);
		}
	
		return self::$config[$group][$path];
	}

}
