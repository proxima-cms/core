<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages_Types extends Controller_Admin_Base {

	public $crud_model = 'page_types';

	public function action_add()
	{
		$this->template->title = __('Add tag');

		$this->template->content = View::factory('admin/page/pages/types/add')
			->bind('errors', $errors)
			->bind('templates', $templates);

		$templates = array();

		foreach(Kohana::list_files('views/'.Theme::path('templates')) as $key => $template)
		{
			$templates[basename($key)] = basename($key);
		}

		if ($_POST)
		{
			if (ORM::factory('page_type')->admin_add($_POST))
			{		
				Message::set(Message::SUCCESS, __('Page type successfully saved.'));		 
				$this->request->redirect('admin/pages/types');
			}	
			else if ($errors = $_POST->errors('admin/pages/types'))
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
			throw new Kohana_Exception('Page type not found.');
		}

		$this->template->title = __('Edit page type');

		$this->template->content = View::factory('admin/page/pages/types/edit')
			->bind('page_type', $page_type)
			->bind('templates', $templates)
			->bind('errors', $errors);

		// Get the file templates.
		$templates = array();
		$template_files = Kohana::list_files('views/'.Theme::path('templates'));

		// Format the templates array.
		foreach($template_files as $key => $template)
		{
			$templates[basename($key)] = basename($key);
		}

		if ($this->request->method() === 'POST')
		{
			try
			{
				$page_type->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __('Page type successfully updated.'));		 

				$this->request->redirect($this->request->uri());
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/page_types');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_delete($id = NULL, $set_message = TRUE)
	{
		// Nasty hack to adjust the redirect URL :/
		$this->crud_model = 'pages/types';
	
		return parent::action_delete();
	}
	
} // End Controller_Admin_Pages_Types
