<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Users_Add extends View_Model_Admin {

	protected $model = 'user';

	public function var_roles()
	{
		return ORM::factory('role')->find_all();
	}

	public function var_groups()
	{
		return ORM::factory('group')->find_all();
	}

	public function var_user_roles()
	{
		return (array) Request::current()->post('roles');
	}

	public function var_user_groups()
	{
		return (array) Request::current()->post('groups');
	}

	public function var_langs()
	{
		return array(
			'en-us' => 'en-us (default)', // English US (default)
			'en-gb' => 'en-gb',           // English UK
			'es-es' => 'es-es',           // Spanish
		);
	}

}
