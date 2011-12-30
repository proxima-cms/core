<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Config extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template
			->title(__('Admin - Config'))
			->content(
				View_Model::factory('admin/page/config/index')
				->bind('config', $config)
				->bind('errors', $errors)
			);

		$group_filter = $this->request->param('group');

		if ($this->request->method() !== Request::POST)
		{
			$config = array();

			$db_config = ORM::factory('config')->find_all();

			foreach($db_config as $item)
			{
				if ($group_filter !== NULL AND $item->group_name !== $group_filter)
				{
					continue;
				}

				if (!isset($config[$item->group_name]))
				{
					$config[$item->group_name] = array();
				}

				$config[$item->group_name][] = $item;
			}
		}
		else
		{
			$config = $this->request->post();

			// Try save the config
			if (ORM::factory('config')->update_all($config))
			{
				Message::set(Message::SUCCESS, __('Config successfully saved.'));

				// Delete the configuration data from cache
				Cache::instance()->delete(Config_Database::$_cache_key);

				// Redirect to prevent POST refresh
				$this->request->redirect($this->request->uri());
			}

			// Get the validation errors
			if ( $errors = $_POST->errors('admin/config'))
			{
				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

} // End Controller_Admin_Config
