<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin groups controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Groups extends Controller_Admin_Base {

	public function action_index()
	{
		$request_data = array('request' => $this->request->query());

		$this->template
			->title(__('Admin - User Groups'))
			->content(
				View_Model::factory('admin/page/groups/index', $request_data)
			);
	}

	public function action_add()
	{
		$this->template
			->title(__('Admin - Add group'))
			->content(
				View_Model::factory('admin/page/groups/add')
				->bind('errors', $errors)
				->bind('group', $group)
			);

		$group = ORM::factory('group');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$group->admin_add($this->request->post());

				Message::set(Message::SUCCESS, __('Group successfully saved.'));

				$this->request->redirect('admin/groups');
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/groups');

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
		$group_id  = $this->request->post('group_id');
		$user_id   = $this->request->post('user_id');

		if ($return_to === NULL OR $group_id === NULL OR $user_id === NULL)
		{
			throw new Request_Exception('Invalid request parameters.');
		}

		$user  = ORM::factory('user', $user_id);
		$group = ORM::factory('group', $group_id);

		if ( ! $user->loaded())
		{
			Message::set(Message::ERROR, __('User not found.'));
		}
		else if ( ! $group->loaded())
		{
			Message::set(Message::ERROR, __('Group not found.'));
		}
		else
		{
			if ( ! $user->has('groups', $group))
			{
				$user->add('groups', $group);
			}
			Message::set(Message::SUCCESS, __('Successfully added user to group.'));
		}

		$this->request->redirect($return_to);
	}

	public function action_edit()
	{
		// Try get the group
		$group = ORM::factory('group', $this->request->param('id'));

		// If group doesn't exist then redirect to admin home
		if ( ! $group->loaded())
		{
			throw new Request_Exception('Group not found.');
		}

		$this->template
			->title(__('Group').' '.$group->name)
			->content(
				View_Model::factory('admin/page/groups/edit')
				->bind('group', $group)
				->bind('errors', $errors)
			);

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$group->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __('Group successfully updated.'));

				$this->request->redirect($this->request->uri());
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/groups');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_delete()
	{
		$group = ORM::factory('group', $this->request->param('id'));

		if ( ! $group->loaded())
		{
			throw new Request_Exception('Group not found.');
		}

		$group->delete();

		Message::set(Message::SUCCESS, __('Group succesfully deleted.'));

		$this->request->redirect('admin/groups');
	}

	public function action_tree()
	{
		$open_groups = Arr::get($_COOKIE, 'groups/index', array());

		if ($open_groups)
		{
			$open_groups = explode(',', $open_groups);
		}

		$this->template->content = ORM::factory('group')->tree_list_html('admin/page/users/tree', 0, $open_groups);
	}

} // End Controller_Admin_Groups
