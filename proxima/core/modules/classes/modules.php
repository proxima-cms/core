<?php defined('SYSPATH') or die('No direct script access.');

class Modules {

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
		
	private static function get_module_config()
	{
		$modules = ORM::factory('module')
			->where('enabled', '=', TRUE)
			->find_all();

		$config = '';

		foreach($modules as $module)
		{		
			$config .= "\t'{$module->name}' => CORPATH.'{$module->name}',\n";
		}		
		$config .= ');';

		$file_path = current(Kohana::find_file('config', 'modules'));

		if ($file_path === FALSE)
		{
			$file_path = APPPATH.'config/modules.php';
		}

		return array($file_path, $config);
	}

	private static function get_nav_config()
	{
		$modules = ORM::factory('module')
			->where('enabled', '=', TRUE)
			->find_all();

		$config = "\t'links' => array(\n";

		foreach($modules as $module)
		{
			$details = array('admin_nav' => FALSE);
	
			// Load the details config file.
			$file = CORPATH.join(DIRECTORY_SEPARATOR, array(
				$module->name,
				'config',
				$module->name,
				'details.php'
			));

			if (file_exists($file))
			{
				$details = require $file;
			}

			if ($details['admin_nav'] === NULL OR $details['admin_nav'] === FALSE)
			{
				continue;
			}

			$config .= "\t\t'admin/{$module->name}' => __('{$details['admin_nav']}'),\n";
		}		

		$config .= "\t)\n);";

		$file_path = current(Kohana::find_file('config', 'admin/navd'));

		if ($file_path === FALSE)
		{
			$file_path = CORPATH.'admin/config/admin/nav.php';
		}

		return array($file_path, $config);
	}

	public static function generate_config()
	{
		$module_config = self::get_module_config();
		$nav_config    = self::get_nav_config();

		self::save_config($module_config);
		self::save_config($nav_config);
	}

}
