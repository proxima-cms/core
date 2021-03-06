<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Pages_Add extends View_Model_Admin {

	public function var_pages()
	{
		return ORM::factory('page')
			->tree_select(4, 0, array(__('None')), 0, 'title');
	}

	public function var_tags()
	{
		return ORM::factory('tag')->order_by('name', 'asc')->find_all();
	}

	public function var_statuses()
	{
		return array(
			'' => __('Live'),
			'1' => __('Draft')
		);
	}

	public function var_page_types()
	{
		$page_types = array('' => 'None');

		foreach(ORM::factory('page_type')->find_all() as $page_type)
		{
			$page_types[$page_type->id] = $page_type->name;
		}

		return $page_types;
	}

}
