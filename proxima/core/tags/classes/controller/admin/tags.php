<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tags extends Controller_Admin_Base {

	public function action_add()
	{
		$this->template->title = __('Add tag');

		$this->template->content = View::factory('admin/page/tags/add')
			->bind('errors', $errors);

		if ($this->request->method() === 'POST')
		{
			if (ORM::factory('tag')->admin_add($_POST))
			{		
				Message::set(Message::SUCCESS, __('Tag successfully saved.'));		 
			}	

			if ($errors = $_POST->errors('admin/tags'))
			{		
				 Message::set(Message::ERROR, __('Please correct the errors.'));
			}

			$_POST = $_POST->as_array();
		}
	}

	public function action_edit()
	{
		$id = (int) $this->request->param('id');

		$tag = ORM::factory('tag', $id);

		if (!$tag->loaded())
		{		
			throw new Kohana_Exception('Tag not found.');
		}		

		$this->template->title = __('Edit tag');

		// If POST is empty then set the default form data
		if (!$_POST)
		{		
			$default_data = $tag->as_array();
		}		

		$this->template->content = View::factory('admin/page/tags/edit')
			->bind('tag', $tag)
			->bind('errors', $errors);
		
		if ($_POST)
		{		
			if ($tag->admin_update($_POST))
			{		
				Message::set(Message::SUCCESS, __('Tag successfully updated.'));		 
				$this->request->redirect($this->request->uri());
			}		

			if ($errors = $_POST->errors('admin/tags'))
			{		
				Message::set(Message::ERROR, __('Please correct the errors.'));
			}		
		}
		else
		{
			// If POST is empty, then add the default data to POST
			$_POST = array_merge($_POST, $default_data);
		}		
	}

	public function action_delete($id = NULL, $set_message = TRUE)
	{
		$ids = explode(',', (string) $this->request->param('id'));

		foreach($ids as $id)
		{
			parent::action_delete($id, false);
		}

  	$message = __('Tag'.(count($ids) > 1?'s':'').' successfully deleted.');
		Message::set(Message::SUCCESS, $message);

		$this->request->redirect('admin/tags');
	}
	
} // End Controller_Admin_Tags
