<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Groups_Edit extends View_Model_Admin {

	public function var_groups()
	{
		return ORM::factory('group')->tree_select(4, 0, array(__('None')));
	}

	public function var_users()
	{
		return Request::factory('admin/users/list/'.$this->group->id)->execute();
	}
	
	public function var_users_select()
	{
		$users = array(__('Please select...'));

		$users_db = ORM::factory('user')
			->order_by('username', 'ASC')
			->find_all();

		foreach($users_db as $user)
		{
			$users[] = $user->username;
		}

		return $users;
	}

}
