<?php defined('SYSPATH') or die('No direct script access.');

class Model_Config extends Model_Base {

	public $_table_name = 'config';

	public function update_all(& $data)
	{
		$data = Validation::factory($data);

		foreach($this->find_all() as $config)
		{
			$rules = unserialize($config->rules);

			$data->rules('config-'.$config->group_name.'-'.$config->config_key, $rules);
		}

		if (!$data->check())
		{
			return FALSE;
		}

		foreach($data->as_array() as $name => $value)
		{			
			if (strstr($name, 'config-') !== FALSE)
			{
				list($config, $group_name, $config_key) = explode('-', $name);

				$config = ORM::factory('config')
					->where('group_name', '=', $group_name)
					->where('config_key', '=', $config_key)
					->find();

				$config->config_value = serialize($value);
				$config->config_key = $config_key;
				$config->save();
			}
		}

		return TRUE;
	}

} // End Model_Config
