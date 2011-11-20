<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Config extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template->title = __('Admin - Config');
		$this->template->content = View::factory('admin/page/config/index')
			->bind('config', $config)
			->bind('errors', $errors);

		$group_filter = $this->request->param('group');

		if ($this->request->method() !== 'POST')
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
	
	public function action_group($group_name = NULL)
	{
		$db_config = ORM::factory('config')
			->where('group_name', '=', $group_name)
			->find_all();
			
		if ($db_config->count() == 0)
		{
			$this->request->redirect('admin/config');
		}
		
		$this->action_index($db_config);
	}

} // End Controller_Admin_Config
