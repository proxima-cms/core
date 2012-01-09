<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Users_Edit extends View_Admin_Page_Users_Add {

	public function var_user_roles()
	{
		$user_roles = array();

		foreach($this->user->roles->find_all() as $role)
		{
			$user_roles[] = $role->id;
		}

		return $user_roles;
	}

	public function var_user_groups()
	{
		$user_groups = array();

		foreach($this->user->groups->find_all() as $group)
		{
			$user_groups[] = $group->id;
		}

		return $user_groups;
	}
}
