<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Modules {

	// Save a config file string to file.
	private static function save_config($data = array())
	{
		list($file_path, $config) = $data;

		$config = "<?php defined('SYSPATH') or die('No direct script access.');\n\n"
			. "/*\n * Auto generated on: " . date('l jS \of F Y h:i:s A') . "\n */\n\n"
			. "return array(\n"
			. $config;

		try
		{
			file_put_contents($file_path, $config);
		}
		// Permission errors.
		catch(ErrorException $e)
		{
			throw $e;
		}
		// Other errors.
		catch(Exception $e)
		{
			throw $e;
		}
	}
	
	// Get module config from the database and return 
	// the module config string.
	private static function get_module_config()
	{
		$modules_db = ORM::factory('module')
			->where('enabled', '=', TRUE)
			->order_by('order', 'ASC')
			->find_all();

		// The following logic moves modules with order of -1 
		// to the end of an array.
		$modules = array(
			'sorted'   => array(),
			'unsorted' => array()
		);
		foreach($modules_db as $module)
		{		
			$key = ((int) $module->order === -1) ? 'unsorted' : 'sorted';

			$modules[$key][] = $module;
		}		
		$modules = array_merge($modules['sorted'], $modules['unsorted']);

		// Now build a string with the config array.
		$config = '';
		foreach($modules as $module)
		{
			$config .= "\t'{$module->name}' => CORPATH.'{$module->name}',\n";
		}
		$config .= ');';

		// Find the modules config file path
		$file_path = current(Kohana::find_file('config', 'modules'));

		if ($file_path === FALSE)
		{
			$file_path = APPPATH.'config/modules'.EXT;
		}

		return array($file_path, $config);
	}

	// Return the module config.
	public static function config($module = '')
	{
		$file = CORPATH.join(DIRECTORY_SEPARATOR, array(
			$module,
			'config',
			$module,
			'details'.EXT
		));

		$config = NULL;

		if (file_exists($file))
		{
			$config = require $file;
		}

		return $config;
	}

	// Get the admin navigation config form the db and 
	// return the navigation config file string.
	private static function get_nav_config()
	{
		$modules = ORM::factory('module')
			->where('enabled', '=', TRUE)
			->find_all();

		$config = "\t'links' => array(\n";

		foreach($modules as $module)
		{
			$mod_config = Modules::config($module->name);

			// FIXME
			if ($mod_config === NULL OR ! Arr::get($mod_config, 'admin_nav'))
			{
				continue;
			}

			$nav_name = $module->nav_name;
			$nav_controller = $module->nav_controller;

			$admin_url  = 'admin/' . ( $module->nav_controller ?: strtolower($module->name) );
			$admin_name = $module->nav_name ?: Arr::get($mod_config, 'name');

			$config .= "\t\t'{$admin_url}' => '{$admin_name}',\n";
		}		

		$config .= "\t)\n);";

		// Get the admin module config file path.
		$file_path = current(Kohana::find_file('config', 'admin/nav'));

		if ($file_path === FALSE)
		{
			$file_path = CORPATH.'admin/config/admin/nav'.EXT;
		}

		return array($file_path, $config);
	}

	// Re-generate the modules init config file and the 
	// admin nav config files.
	public static function generate_config()
	{
		$module_config = self::get_module_config();
		$nav_config    = self::get_nav_config();

		self::save_config($module_config);
		self::save_config($nav_config);
	}

	// Save all module file data to the database.
	public static function save_all()
	{
		$modules = Kohana::list_files(NULL, array(CORPATH, MODPATH));
			
		foreach($modules as $name => $module)
		{
			$config         = Modules::config($name);
			$enabled        = Arr::get($config, 'enabled', TRUE);
			$order          = Arr::get($config, 'load_order', -1);
			$admin_nav      = Arr::get($config, 'admin_nav', array());
			$nav_controller = Arr::get($admin_nav, 'controller');
			$nav_name       = Arr::get($admin_nav, 'name') ?: Arr::get($config, 'name');

			ORM::factory('module')
				->where('name', '=', $name)
				->find()
				->values(array(
					'name' => $name,
					'nav_controller' => $nav_controller,
					'nav_name' => $nav_name,
					'enabled' => $enabled,
					'order' => $order
				))  
				->save();
		}
	}
}
