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

		foreach(Kohana::list_files(rtrim(CORPATH, DIRECTORY_SEPARATOR), array('')) as $path => $dir)
		{   
			$modules[str_replace(CORPATH, '', $path)] = $path;
		}  
		foreach(Kohana::list_files(rtrim(MODPATH, DIRECTORY_SEPARATOR), array('')) as $path => $dir)
		{
			$modules[str_replace(MODPATH, '', $path)] = $path;
		}
	}

	private function save($enabled = FALSE)
	{
		$module = $this->request->param('module');

		if ($module === NULL)
		{
			$this->request->redirect('admin/modules');
		}

		ORM::factory('module')
			->where('name', '=', $module)
			->find()
			->values(array(
				'name'    => $module,
				'enabled' => $enabled
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

} // End Controller_Admin_Modules
