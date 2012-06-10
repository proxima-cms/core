<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Assets_Folders_Add extends View_Model_Admin {

	public function var_folders()
	{
		return ORM::factory('asset_folder')->tree_select(4, 0, array('' => __('None')), 0, 'name');
	}

	public function var_return_to()
	{
		return Arr::get($this->request, 'return_to');
	}
}
