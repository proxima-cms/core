<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Home extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template
			->title(__('Admin'))
			->content(
				View::factory('admin/page/home/index')
				->bind('db_config', $db_config)
				->bind('modules', $modules)
			); 

		// Get the database configuration
		$db_config = Kohana::$config->load('database.default');

		// Get an array of enabled modules
		$modules = Kohana::modules();
	}

} // End Controller_Admin_Home
