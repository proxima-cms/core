<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Users_Add extends View_Model_Admin {
	
	protected $model = 'user';

	public function var_roles()
	{
		return ORM::factory('role')->find_all();
	}

	public function var_groups()
	{
		return ORM::factory('group')->find_all();
	}

}
