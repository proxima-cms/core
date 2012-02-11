<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Users_Edit extends Proxima_View_Model_Admin_Page_Users_Add  {

	public function var_user_roles()
	{
		return array_keys($this->user->roles->find_all()->as_array('id'));
	}

	public function var_user_groups()
	{
		return array_keys($this->user->groups->find_all()->as_array('id'));
	}
}
