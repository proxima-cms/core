<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Assets_Upload extends View_Model_Admin {

	public function var_allowed_upload_type()
	{
		return Kohana::$config->load('admin/assets.allowed_upload_type');
	}

	public function var_max_file_uploads()
	{
		return Kohana::$config->load('admin/assets.max_file_uploads');
	}

	public function var_accept_type()
	{
		return preg_replace('/,\s*/', '|', $this->allowed_upload_type);
	}

	public function var_folders()
	{
		return ORM::factory('asset_folder')->tree_select(4, 0, array(__('None')), 0, 'name');
	}
}
