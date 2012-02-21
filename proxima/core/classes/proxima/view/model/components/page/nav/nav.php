<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Components_Page_Nav_Nav extends View_Model {

	public function var_pages()
	{
		return ORM::factory('site_page')
			->where('parent_id', '=', $this->parent_id)
			->where('visible_in_nav', '=', 1)
			->find_all();
	}
}
