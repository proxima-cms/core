<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Assets_Edit extends View_Model_Admin {

	public function var_resized()
	{
		return $this->asset->sizes->where('resized', '=', 1)->find_all();
	}
		
	public function var_links()
	{
		return View_Model::factory('admin/page/assets/index', array('request' => $this->request))
			->get_filter_links();
	}
}
