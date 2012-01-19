<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Assets_Edit extends View_Model_Admin {

	public function var_resized()
	{
		return $this->asset->sizes->where('resized', '=', 1)->find_all();
	}

	public function var_links()
	{
		return View_Model::factory('admin/page/assets/index', array('request' => $this->request))
			->get_filter_links(NULL, 'admin/assets');
	}

	// Return a folder tree select.
	public function var_folders()
	{
		return ORM::factory('asset_folder')
			->tree_select(4, 0, array(__('None')), 0, 'name');
	}

	// Return the current folder.
	public function var_cur_folder()
	{
		return 0;
	}

	// Returns the current url with the 'folder' query string param as an underscore.js template.
	public function var_folder_uri_template()
	{
		$links = $this->links;

		$query = Request::current()->query();

		$query['folder'] = '<%= folder %>';

		return urldecode(URL::site(Route::get('admin')->uri(array('controller' => 'assets')) . '?' . http_build_query($query)));
	}
}
