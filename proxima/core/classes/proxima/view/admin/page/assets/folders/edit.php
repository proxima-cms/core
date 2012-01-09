<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Assets_Folders_Edit extends View_Model_Admin {

	// Return a folder tree select.
	public function var_folders()
	{
		return ORM::factory('asset_folder')
			->tree_select(4, 0, array(__('None')), 0, 'name');
	}
	
}
