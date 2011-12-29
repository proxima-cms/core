<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Assets_Popup_Index extends View_Admin_Page_Assets_Index {
	
	public function var_upload_html()
	{
		return View_Model::factory('admin/page/assets/popup/upload')->set('errors', array());
	}
}
