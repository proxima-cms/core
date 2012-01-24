<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Modules_Index extends View_Model_Admin_Page_Index {

	protected $model = 'module';

	// Return an array of enabled modules.
	public function var_enabled_modules()
	{
	 	$enabled_db_modules = ORM::factory('module')
			->where('enabled', '=', 1)
			->find_all();

		$enabled_file_modules = array_keys(Kohana::modules());

		$enabled_modules = array();

		foreach($enabled_db_modules as $module)
		{
			if (in_array($module->name, $enabled_file_modules))
			{
				$enabled_modules[] = $module->name;
			}
		}

		return $enabled_modules;
	}

	// Return an array of all enabled Kohana modules.
	public function var_kohana_modules()
	{
		return Kohana::modules();
	}

	public function var_default_modules()
	{
		return Kohana::$config->load('default.modules');
	}

	// Return an array of all addon modules found on filesystem.
	// Addon modules are those not found in the default modules load list.
	public function var_addon_modules()
	{
		$modules_file = Kohana::list_files(NULL, array(MODPATH, CORMODPATH));

		$default_modules = Kohana::$config->load('default.modules');

		$addon_modules = array();

		foreach($modules_file as $name => $module)
		{
			if (!in_array($name, $default_modules))
			{
				$addon_modules[$name] = $name;
			}
		}

		return $addon_modules;
	}
}
