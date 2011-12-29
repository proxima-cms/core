<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Modules_Index extends View_Model_Admin_Page_Index {
	
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

	// Return an array of all modules found on filesystem.
	public function var_modules()
	{
		$modules = array();

		$files = Kohana::list_files(NULL, array(CORPATH, MODPATH));

		foreach($files as $name => $module)
		{   
			$modules[str_replace(CORPATH, '', $name)] = $name;
		}   

		return $modules;
	}
}
