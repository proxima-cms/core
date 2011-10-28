<?php defined('SYSPATH') or die('No direct script access.');
/*
* User model
* some concepts and code taken from https://github.com/GeertDD/kohanajobs/blob/master/application/classes/model/user.php
*/

class Controller_Admin_Users extends Controller_Admin_Base {

	public function action_add()
	{
		$this->template->title = __('Add user');

		$this->template->content = View::factory('admin/page/users/add')
			->bind('roles', $roles)
			->bind('users', $users)
			->bind('groups', $groups)
			->bind('errors', $errors);

		$roles = ORM::factory('role')->find_all();
		$groups = ORM::factory('group')->find_all();

		if ($this->request->method() === 'POST')
		{
			try
			{
				ORM::factory('user')->admin_add($this->request->post());

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
		$id = (int) $this->request->param('id');

		$user = ORM::factory('user', $id);

		if (!$user->loaded())
		{
			throw new HTTP_Exception_500('User not found.');
		}

		$this->template->title = __('Edit user').' '.$user->username;

		// Bind user data to template
		$this->template->content = View::factory('admin/page/users/edit')
			->bind('roles', $roles)
			->bind('groups', $groups)
			->bind('user', $user)
			->bind('user_roles', $user_roles)
			->bind('user_groups', $user_groups)
			->bind('errors', $errors);

		// Find all roles
		$roles = ORM::factory('role')->find_all();
				
		// Create array of user role ids
		$user_roles = array();

		foreach($user->roles->find_all() as $role)
		{
			$user_roles[] = $role->id;
		}

		// Find all groups
		$groups = ORM::factory('group')->find_all();
				
		// Create array of user group ids
		$user_groups = array();

		foreach($user->groups->find_all() as $group)
		{
			$user_groups[] = $group->id;
		}
		
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

	public function action_delete($id = NULL, $set_message = TRUE)
	{
		$id = (int) $this->request->param('id');

		// Don't delete user 1
		$id === 1 AND $this->request->redirect('403');

		// Try load the user
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

		$this->template->content = ORM::factory('group')->tree_list_html('admin/page/users/tree', 0, $open_groups);
	}

} // End Controller_Admin_users
