<?php defined('SYSPATH') or die('No direct script access.');

class Config_Database extends Kohana_Config_Database {

	protected $_cache_lifetime = NULL;
	
	protected $_table_name	= 'config';

	protected $_cache = NULL;

	public static $_cache_key = 'database_config';

	public function __construct(array $config = NULL)
	{
		if ($this->_cache_lifetime === NULL)
		{
			$this->_cache_lifetime = PHP_INT_MAX;
		}
		
		self::$_cache_key = sha1(self::$_cache_key);

		$this->_cache = Cache::instance()->get(self::$_cache_key);
		
		if (!$this->_cache)
		{
			// Load all of the configuration values
			$query = DB::select('config_key', 'config_value', 'group_name')
				->from($this->_table_name)
				->execute($this->_db_instance);

			$this->_cache = array();

			// Build the cache configuration array that contains ALL the config entries
			foreach($query as $entry)
			{
				if (!isset($this->_cache[$entry['group_name']]))
				{
					$this->_cache[$entry['group_name']] = array();
				}

				$this->_cache[$entry['group_name']][$entry['config_key']] = unserialize($entry['config_value']);
			}

			// Save the configuration in cache
			Cache::instance()->set(self::$_cache_key, $this->_cache, $this->_cache_lifetime);
		}

		return parent::__construct($config);
	}

	/** 
	 * Tries to load the specificed configuration group
	 *
	 * Returns FALSE if group does not exist or an array if it does
	 *
	 * @param  string $group Configuration group
	 * @return boolean|array
	 */
	public function load($group)
	{
		// Use the group config if it exists
		$config = Arr::get($this->_cache, $group, FALSE);

		return $config;
	}

} // End Config_Database
