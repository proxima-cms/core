<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pagetypes extends Controller_Admin_Base {

	public function action_add()
	{
		$this->template->title = __('Add tag');

		$this->template->content = View::factory('admin/page/pagetypes/add')
			->bind('errors', $errors)
			->bind('templates', $templates);

		$templates = array();
		foreach(Kohana::list_files('views/themes/default/templates') as $key => $template)
		{
			$templates[basename($key)] = basename($key);
		}

		if ($_POST)
		{
			if (ORM::factory('pagetype')->admin_add($_POST))
			{		
				Message::set(Message::SUCCESS, __('Page type successfully saved.'));		 
				$this->request->redirect('admin/pagetypes');
			}	

			if ($errors = $_POST->errors('admin/pagetypes'))
			{		
				 Message::set(Message::ERROR, __('Please correct the errors.'));
			}

			$_POST = $_POST->as_array();
		}
	}
	

	public function action_edit()
	{
		$id = (int) $this->request->param('id');

		$pagetype = ORM::factory('pagetype', $id);

		if (!$pagetype->loaded())
		{
			throw new Kohana_Exception('Pagetype not found.');
		}

		$this->template->title = __('Edit pagetype');

		// If POST is empty then set the default form data
		if (!$_POST)
		{
			$default_data = $pagetype->as_array();
		}

		$this->template->content = View::factory('admin/page/pagetypes/edit')
			->bind('pagetype', $pagetype)
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
			if ($pagetype->admin_update($_POST))
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
