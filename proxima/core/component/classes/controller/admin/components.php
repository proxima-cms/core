<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Components extends Controller_Admin_Base {

	public function action_index()
	{
		$request_data = array(
			'request' => $this->request->query()
		);  

		$this->template->title = __('Components');

		$this->template->content = View_Model::factory('admin/page/components/index', $request_data); 
	}

	public function action_add()
	{
		$request_data = array(
			'request' => $this->request->post()
		);  

		$this->template->title = __('Add component');

		$this->template->content = View_Model::factory('admin/page/components/add', $request_data)
			->bind('errors', $errors)
			->bind('component', $component);

		$component = ORM::factory('component');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$component->admin_add($this->request->post());

				Message::set(Message::SUCCESS, __('Component successfully saved.'));
				
				Request::current()->redirect('admin/components/edit/'.$component->id);
			} 
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/components');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}
	
	public function action_edit()
	{
		$request_data = array(
			'request' => $this->request->post()
		);  

		$this->template->title = __('Edit page');

		$this->template->content = View_Model::factory('admin/page/components/edit', $request_data)
			->bind('errors', $errors)
			->bind('component', $component);

		$id = Request::current()->param('id');

		$component = ORM::factory('component', $id);

		if (!$component->loaded())
		{
			throw new Kohana_Request_Exception('Component not found.');
		}

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$component->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __('Component successfully updated.'));
			
				Request::current()->redirect('admin/components/edit/'.$id);
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/components');

 				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}
} // End Controller_Admin_Components
