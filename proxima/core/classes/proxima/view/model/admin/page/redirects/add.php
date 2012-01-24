<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Redirects_Add extends View_Model_Admin {

	public function var_pages()
	{
		return ORM::factory('page')->tree_select(4, 0, array('' => __('None')), 0, 'title');
	}

}
