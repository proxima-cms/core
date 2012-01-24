<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Groups_Add extends View_Model_Admin {

	public function var_groups()
	{
		return ORM::factory('group')->tree_select(4, 0, array(__('None')));
	}

}
