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

	// Return a folder tree select.
	public function var_folders()
	{
		return ORM::factory('asset_folder')
			->tree_select(4, 0, array(__('None')), 0, 'name');
	}
}
