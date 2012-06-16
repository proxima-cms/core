<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Assets_Popup_Index extends View_Model_Admin_Page_Assets_Index {
	
	public function var_upload_html()
	{
		return Request::factory('admin/assets/popup/upload')->execute();
	}
}
