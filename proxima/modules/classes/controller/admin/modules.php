<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Modules extends Controller_Admin_Base {

	public function action_index()
	{
		$request_data = array('request' => $this->request->query());  

		Page_View::instance()
			->title(__('Admin - Modules'))
			->content(
				View_Model::factory('admin/page/modules/index', $request_data)
			); 
	}

	private function save($enabled = FALSE)
	{
		$module = $this->request->param('module');

		if ($module === NULL)
		{
			Message::set(Message::ERROR, 'Module name not specified');

			$this->request->redirect('admin/modules');
		}

		$mod_config     = Modules::config($module);
		$order          = Arr::get($mod_config, 'load_order', -1);
		$admin_nav      = Arr::get($mod_config, 'admin_nav', array());
		$nav_controller = Arr::get($admin_nav, 'controller');
		$nav_name       = Arr::get($admin_nav, 'name');

		ORM::factory('module')
			->where('name', '=', $module)
			->find()
			->values(array(
				'name' => $module,
				'nav_controller' => $nav_controller,
				'nav_name' => $nav_name,
				'enabled' => $enabled,
				'order' => $order
			))
			->save();

		// Generate the enabled modules config file.
		Modules::generate_config();

		Message::set(
			Message::SUCCESS, 
			__('Module successfully :state.', array(
				':state' => $enabled ? __('enabled') : __('disabled')
			))
		);

		$this->request->redirect('admin/modules');
	}

	public function action_enable()
	{
		$this->save(TRUE);
	}
	
	public function action_disable()
	{
		$this->save(FALSE);
	}

	public function action_generate_config()
	{
		Modules::save_all();
		Modules::generate_config();

		Message::set(Message::SUCCESS, __('Modules successfully updated.'));

		$this->request->redirect('admin/modules');
	}

} // End Controller_Admin_Modules
