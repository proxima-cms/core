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

	public function action_adduser()
	{
		if ($this->request->method() !== Request::POST)
		{
			throw new Request_Exception('This request can only be executed by '.Request::POST);
		}

		$return_to = $this->request->query('return_to');
		$role_id  = $this->request->post('role_id');
		$user_id   = $this->request->post('user_id');

		if ($return_to === NULL OR $role_id === NULL OR $user_id === NULL)
		{
			throw new Request_Exception('Invalid request parameters.');
		}

		$user  = ORM::factory('user', $user_id);
		$role = ORM::factory('role', $role_id);

		if ( ! $user->loaded())
		{
			Message::set(Message::ERROR, __('User not found.'));
		}
		else if ( ! $role->loaded())
		{
			Message::set(Message::ERROR, __('Role not found.'));
		}
		else
		{
			if ( ! $user->has('roles', $role))
			{
				$user->add('roles', $role);
			}
			Message::set(Message::SUCCESS, __('Successfully added user to role.'));
		}

		$this->request->redirect($return_to);
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
