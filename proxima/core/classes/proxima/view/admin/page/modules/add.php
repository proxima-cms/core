<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Modules_Add extends View_Model_Admin {

	public function var_allowed_upload_type()
	{
		return implode(', ', array('tar', 'zip'));
	}

	public function var_max_file_uploads()
	{
		return 1;
	}

}
