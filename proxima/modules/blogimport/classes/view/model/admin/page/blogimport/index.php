<?php defined('SYSPATH') or die('No direct script access.');

class View_Model_Admin_Page_Blogimport_Index extends View_Model_Admin {

	public function var_pages()
	{
		return ORM::factory('page')->tree_select(4, 0, array(__('None')), 0, 'title');
	}

	public function var_page_types()
	{
		$page_types = array();

		foreach($types = ORM::factory('page_type')->find_all() as $type)
		{
			$page_types[$type->id] = $type->name;
		}

		return $page_types;
	}
}
