<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Roles extends Controller_Admin_Base {

	public function action_index()
	{
		$request_data = array('request' => $this->request->query());  

		$this->template
			->title(__('Admin - Roles'))
			->content(
				View_Model::factory('admin/page/roles/index', $request_data)
			);  
	}

	public function action_add()
	{
		$this->template
			->title(__('Admin - Add role'))
			->content(
				View_Model::factory('admin/page/roles/add')
				->bind('errors', $errors)
				->bind('role', $role)
			);
	
		$role = ORM::factory('role');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$role->admin_create($this->request->post());

				Message::set(Message::SUCCESS, __('Role successfully saved.'));			
				
				$this->request->redirect(
					Route::get('admin')
					->uri(array('controller' => 'roles'))
				);
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/roles');
			 
				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_edit()
	{
		$role = ORM::factory('role', $this->request->param('id'));

		if ( ! $role->loaded())
		{
			throw new Request_Exception('Role not found.');
		}

		$this->template
			->title(_('Admin - Edit role - ').$role->name)
			->content(
				View_Model::factory('admin/page/roles/edit')
				->set('role', $role)
				->bind('errors', $errors)
			);

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$role->admin_update($this->request->post());
				
				Message::set(Message::SUCCESS, __('Role successfully updated.'));			 
				
				$this->request->redirect($this->request->uri());
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/roles');
			
				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_delete()
	{
		$role = ORM::factory('role', $this->request->param('id'));

		if ( ! $role->loaded())
		{   
			throw new Request_Exception('Role not found.');
		}   

		$role->delete();

		Message::set(Message::SUCCESS, __('Role succesfully deleted.'));
		
		$this->request->redirect(
			Route::get('admin')
			->uri(array('controller' => 'roles'))
		);
	}
}
