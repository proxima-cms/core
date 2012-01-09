<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Cache_Apc extends Kohana_Cache_Apc {

	// Overload the set method to prevent setting the cache if value 
	// is less than 0. (By default, a TTL of 0 or less will mean
	// cache will persist until removed.)
	public function set($id, $data, $lifetime = NULL)
	{
		if ($lifetime === NULL)
		{		
			$lifetime = Arr::get($this->_config, 'default_expire', Cache::DEFAULT_EXPIRE);
		}		

		return ($lifetime < 0) ? FALSE : parent::set($id, $data, $lifetime);
	}
}
