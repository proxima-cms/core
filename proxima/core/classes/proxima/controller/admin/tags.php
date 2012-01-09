<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Tags extends Controller_Admin_Base {

	public function action_index()
	{

		$request_data = array('request' => $this->request->query());  

		$this->template
			->title(__('Admin - Tags'))
			->content(
				View_Model::factory('admin/page/tags/index', $request_data)
			); 
	}

	public function action_add()
	{
		$request_data = array('request' => $this->request->query());  

		$this->template
			->title(__('Admin - Add tag'))
			->content(
				View_Model::factory('admin/page/tags/add', $request_data)
				->bind('errors', $errors)
				->bind('tag', $tag)
			);

		$tag = ORM::factory('tag');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$tag->admin_add($this->request->post());

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
		$tag = ORM::factory('tag', $this->request->param('id'));

		if (!$tag->loaded())
		{		
			throw new Exception('Tag not found.');
		}		
		
		$request_data = array('request' => $this->request->query());  

		$this->template
			->title(__('Admin - Edit tag'))
			->content(
				View_Model::factory('admin/page/tags/edit', $request_data)
				->bind('errors', $errors)
				->set('tag', $tag)
			);

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
			ORM::factory('tag', $id)->delete();
		}

		$message = __('Tag'.(count($ids) > 1?'s':'').' successfully deleted.');

		Message::set(Message::SUCCESS, $message);

		$this->request->redirect('admin/tags');
	}
	
} // End Controller_Admin_Tags
