<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Modules extends Controller_Admin_Base {

	public function action_index()
	{
		$request_data = array('request' => $this->request->query());

		$this->template
			->title(__('Admin - Modules'))
			->content(
				View_Model::factory('admin/page/modules/index', $request_data)
			);
	}

	public function action_add()
	{
		$request_data = array('request' => $this->request->query());

		$this->template
			->title(__('Admin - Modules - Add'))
			->content(
				View_Model::factory('admin/page/modules/add', $request_data)
				->bind('errors', $errors)
			);

		if ($this->request->method() === Request::POST)
		{
			$upload_fieldname = 'module_file';
			$data = $_FILES + $this->request->post();

			$module = ORM::factory('module');

			if (Arr::get($data, $upload_fieldname))
			{
	 			try
 	 	  	{
					$module->admin_upload($data, $upload_fieldname);
				}
				// Error validating the uploaded files.
				catch(Validation_Exception $e)
				{
					$errors = $e->array->errors('admin/assets');
				}
				// Error processing the uploaded files.
				catch(Exception $e)
				{
					Message::set(Message::ERROR, $e->getMessage());

					$this->request->redirect(Route::get('admin')->uri(array('controller' => 'modules', 'action' => 'add')));
				}
				// Error saving the module data to the db.
				catch(ORM_Validation_Exception $e)
				{
					$errors = $e->errors('admin/assets');
				}

				if ($errors === NULL)
				{
					$message = __('Module successfully upload. You must enable this module if you wish to use it.');

					Message::set(Message::SUCCESS, $message);

					$this->request->redirect(Route::get('admin')->uri(array('controller' => 'modules')));
				}
				else
				{
					$message = __('Error uploading files.');

					Message::set(Message::ERROR, __($message, array(':errors_count' => count($errors))));
				}
			}
		}
	}

	public function action_enable()
	{
		$this->save_module(TRUE);
	}

	public function action_disable()
	{
		$this->save_module(FALSE);
	}

	public function action_remove()
	{
		$module = $this->request->param('module');
		$folder = CORMODPATH.$module;
		$stderr = exec(sprintf('rm -r %s 2>&1', escapeshellarg($folder)));

		if (strpos($stderr, 'Permission denied') !== FALSE)
		{
			Message::set(Message::ERROR, __('Unable to delete module from filesystem.'));
		}
		else
		{
			$module_db = ORM::factory('module', array('name' => $module));

			if ($module_db->loaded())
			{
				$module_db->delete();
			}

			// Re-generate the module config file
			Modules::generate_config();

			Message::set(Message::SUCCESS, __('Module successully deleted.'));
		}

		$this->request->redirect(Route::get('admin')->uri(array('controller' => 'modules')));
	}

	public function action_generate_config()
	{
		Modules::save_all();
		Modules::generate_config();
		Message::set(Message::SUCCESS, __('Modules successfully updated.'));

		$this->request->redirect('admin/modules');
	}

	private function save_module($enabled = FALSE)
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
}
