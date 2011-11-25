<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Modules extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template->title = __('Admin - Modules');
		$this->template->content = View::factory('admin/page/modules/index')
			->bind('modules', $modules)
			->bind('enabled_modules', $enabled_modules);

		$enabled_modules = array_keys(Kohana::modules());

		$modules = array();
		$files = Kohana::list_files(NULL, array(CORPATH, MODPATH));

		foreach($files as $name => $module)
		{   
			$modules[str_replace(CORPATH, '', $name)] = $name;
		}  
	}

	private function save($enabled = FALSE)
	{
		$module = $this->request->param('module');

		if ($module === NULL)
		{
			Message::set(Message::ERROR, 'Module name not specified');

			$this->request->redirect('admin/modules');
		}

		$mod_config = Modules::config($module);
		$order      = Arr::get($mod_config, 'load_order', -1);

		ORM::factory('module')
			->where('name', '=', $module)
			->find()
			->values(array(
				'name'    => $module,
				'enabled' => $enabled,
				'order'   => $order
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
