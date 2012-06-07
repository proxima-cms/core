<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Modules helper class.
 * This class provides helper methods to re-generate module-related data in
 * the database and on the filesystem.
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Modules {

	// Save a config file string to file.
	private static function save_config($data = array(), $notes = array())
	{
		list($file_path, $config) = $data;

		$config = "<?php defined('SYSPATH') or die('No direct script access.');\n\n"
			. "/*\n * Auto generated on: " . date('l jS \of F Y h:i:s A') . "\n"
			. " * Notes: ".implode("\n\n", $notes)."\n */\n\n"
			. "return ".$config.";";

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
	
	// Return the module config.
	public static function config($module = '')
	{
		$file = CORMODPATH.join(DIRECTORY_SEPARATOR, array(
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


	// Get module config from the database and return
	// the module config string.
	private static function get_module_config()
	{
		// Get the enabled addon modules.
		$modules = ORM::factory('module')
			->where('enabled', '=', TRUE)
			->order_by('order', 'ASC')
			->find_all();

		$config = array();

		// Add the addon modules
		foreach($modules as $module)
		{
			$config[$module->name] = "CORMODPATH.{$module->name}";
		}

		$config['core'] = "CORPATH";

		// Add the default core modules.
		foreach(Kohana::$config->load('default.modules') as $module)
		{
			$config[$module] = ($module === 'core' ? '' : "MODPATH.").$module;
	  }

		$config = var_export($config, true);
		$config = str_replace('\'CORMODPATH.', 'CORMODPATH.\'', $config);
		$config = str_replace('\'MODPATH.', 'MODPATH.\'', $config);
		$config = str_replace('\'CORPATH\'', 'CORPATH', $config);

		if (($file_path = current(Kohana::find_file('config', 'modules'))) === FALSE)
		{
			$file_path = APPPATH.'config/modules'.EXT;
		}

		return array($file_path, $config);
	}

	// Returns the admin navigation config string
	// It need lots of work.
	private static function get_nav_config()
	{
		$links = Kohana::$config->load('admin/default.nav.links');

		$modules = ORM::factory('module')
			->where('enabled', '=', TRUE)
			->find_all();

		// Add the addon modues
		foreach($modules as $module)
		{
			$mod_config     = Modules::config($module->name);
			$nav_name       = $module->nav_name;
			$nav_controller = $module->nav_controller;
			$admin_url      = 'admin/' . ( $module->nav_controller ?: strtolower($module->name) );
			$admin_name     = $module->nav_name ?: Arr::get($mod_config, 'name');

			if (!Arr::get($mod_config, 'admin_nav'))
			{
				continue;
			}

			$links['#nav-modules']['groups']['Addon modules'][$admin_url] = array('text' => __($admin_name));
		}

		if (($file_path = current(Kohana::find_file('config', 'admin/nav'))) === FALSE)
		{
			$file_path = CORPATH.'admin/config/admin/nav'.EXT;
		}

		$links = var_export(array('links' => $links), TRUE);

		return array($file_path, $links);
	}

	// Re-generate the modules init config file and the
	// admin nav config files.
	public static function generate_config()
	{
		$module_config = self::get_module_config();
		$nav_config    = self::get_nav_config();

		self::save_config($module_config);
		self::save_config($nav_config, array(
			__('Change the default admin navigation links in :file', array(':file' => 'config/admin/default.php'))
		));
	}

	// Save all module file data to the database.
	public static function save_all()
	{
		$modules = Kohana::list_files(NULL, array(CORMODPATH));

		foreach($modules as $name => $module)
		{
			$config = Modules::config($name);

			$module_db = ORM::factory('module')
				->where('name', '=', $name)
				->find();

			// If no config found then delete the module
			if ($config === NULL)
			{
				if ($module_db->loaded())
				{
					$module_db->delete();
				}

				throw new Kohana_Exception('Unable to save Proxima module \'' . $name .'\' to DB. The module requires configuration.');
			}

			$enabled        = $module_db->loaded() ? $module_db->enabled : Arr::get($config, 'enabled', TRUE);
			$order          = Arr::get($config, 'load_order', 0);
			$admin_nav      = Arr::get($config, 'admin_nav', array());
			$nav_controller = Arr::get($admin_nav, 'controller');
			$nav_name       = Arr::get($admin_nav, 'name') ?: Arr::get($config, 'name');

			$module_db
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
