<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tags extends Controller_Admin_Base {

	public function action_index()
	{
		$request_data = array(
			'request' => $this->request->query()
		);  

		$this->template->title = __('Tags');

		$this->template->content = View_Model::factory('admin/page/tags/index', $request_data); 
	}

	public function action_add()
	{
		$this->template->title = __('Add tag');

		$this->template->content = View::factory('admin/page/tags/add')
			->bind('errors', $errors);

		if ($this->request->method() === Request::POST)
		{
			try
			{
				ORM::factory('tag')->admin_add($this->request->post());

				Message::set(Message::SUCCESS, __('Tag successfully saved.'));		 

				$this->request->redirect('admin/tags');
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/tags');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
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

		$this->template->content = View::factory('admin/page/tags/edit')
			->bind('tag', $tag)
			->bind('errors', $errors);

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$tag->admin_update($this->request->post());
				
				Message::set(Message::SUCCESS, __('Tag successfully updated.'));		 
				
				$this->request->redirect($this->request->uri());
			}		
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/tags');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}		
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
