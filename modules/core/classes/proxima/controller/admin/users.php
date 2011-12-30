<?php defined('SYSPATH') or die('No direct script access.');
/*
* User model
* some concepts and code taken from https://github.com/GeertDD/kohanajobs/blob/master/application/classes/model/user.php
*/

class Proxima_Controller_Admin_Users extends Controller_Admin_Base {

	public function action_index()
	{
		$request_data = array('request' => $this->request->query());  

		$this->template
			->title(__('Admin - Users'))
			->content(
				View_Model::factory('admin/page/users/index', $request_data)
			);
	}

	public function action_list()
	{
		$request_data = array(
			'request' => $this->request->query(),
			'group_id' => $this->request->param('id')
		);

		$this->template
			->title(__('Admin - Users'))
			->content(
				View_Model::factory('admin/page/users/list', $request_data)
			);
	}

	public function action_add()
	{
		$request_data = array('request' => $this->request->query());  

		$this->template
			->title(__('Admin - Add user'))
			->content(
				View_Model::factory('admin/page/users/add', $request_data)
				->bind('errors', $errors)
				->bind('user', $user)
			);

		$user = ORM::factory('user');

		if ($this->request->method() === 'POST')
		{
			try
			{
				$user->admin_add($this->request->post());

				Message::set(Message::SUCCESS, __('User successfully saved.'));

				$this->request->redirect('admin/users');
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/users');
				 
				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_edit()
	{
		$user = ORM::factory('user', $this->request->param('id'));

		if (!$user->loaded())
		{
			throw new Exception('User not found.');
		}
		
		$request_data = array('request' => $this->request->query());  

		$this->template
			->title(__('Admin - Edit user'))
			->content(
				View_Model::factory('admin/page/users/edit', $request_data)
				->bind('errors', $errors)
				->set('user', $user)
			);

		if ($this->request->method() === 'POST')
		{
			try
			{
				$user->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __('User successfully updated.'));

				$this->request->redirect($this->request->uri());
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/users');
				 
				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_delete()
	{
		$id = (int) $this->request->param('id');

		// Don't delete user 1
		$id === 1 AND $this->request->redirect('403');

		$user = ORM::factory('user', $id);

		if (!$user->loaded())
		{
			$this->request->redirect('admin');
		}

		// Remove the user's roles relationship
		foreach ($user->roles->find_all() as $role)
		{
			$user->remove('roles', $role);
		}

		// Delete the user
		$user->delete();

		Message::set(Message::SUCCESS, __('User successfully deleted.'));

		$this->request->redirect('admin/users');
	}
	
	public function action_tree()
	{
		$open_groups = Arr::get($_COOKIE, 'users/index', array());
		
		if ($open_groups)
		{
			$open_groups = explode(',', $open_groups);
		}
		
		$this->template
			->content(
				ORM::factory('group')
				->tree_list_html('admin/page/users/tree', 0, $open_groups)
			);
	}

} // End Controller_Admin_users
