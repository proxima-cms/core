<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages_Types extends Controller_Admin_Base {

	public $crud_model = 'page_types';

	public function action_add()
	{
		$this->template->title = __('Add tag');

		$this->template->content = View::factory('admin/page/page_types/add')
			->bind('errors', $errors)
			->bind('templates', $templates);

		$templates = array();
		foreach(Kohana::list_files('views/themes/default/templates') as $key => $template)
		{
			$templates[basename($key)] = basename($key);
		}

		if ($_POST)
		{
			if (ORM::factory('page_type')->admin_add($_POST))
			{		
				Message::set(Message::SUCCESS, __('Page type successfully saved.'));		 
				$this->request->redirect('admin/page_types');
			}	

			if ($errors = $_POST->errors('admin/page_types'))
			{		
				 Message::set(Message::ERROR, __('Please correct the errors.'));
			}

			$_POST = $_POST->as_array();
		}
	}
	

	public function action_edit()
	{
		$id = (int) $this->request->param('id');

		$page_type = ORM::factory('page_type', $id);

		if (!$page_type->loaded())
		{
			throw new Kohana_Exception('Pagetype not found.');
		}

		$this->template->title = __('Edit page_type');

		// If POST is empty then set the default form data
		if (!$_POST)
		{
			$default_data = $page_type->as_array();
		}

		$this->template->content = View::factory('admin/page/types/edit')
			->bind('page_type', $page_type)
			->bind('templates', $templates)
			->bind('errors', $errors);
		
		$templates = array();
		foreach(Kohana::list_files('views/themes/default/templates') as $key => $template)
		{
			$templates[basename($key)] = basename($key);
		}

		if ($_POST)
		{
			// Try update the role, if successful then reload the page
			if ($page_type->admin_update($_POST))
			{		
				Message::set(Message::SUCCESS, __('Page type successfully updated.'));		 
				$this->request->redirect($this->request->uri());
			}

			if ($errors = $_POST->errors('admin/roles'))
			{
				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		} else {
			// If POST is empty, then add the default data to POST
			$_POST = array_merge($_POST, $default_data);
		}

	}


	
} // End Controller_Admin_Tags
