<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin extends View_Model {

	public function var_breadcrumbs()
	{
		$pages = array();

		foreach($segments = explode('/', Request::current()->uri()) as $key => $page)
		{
			$pages[] = array(
				'title' => $page,
				'url' => URL::site(join('/', array_slice($segments, 0, ($key + 1))))
			);
		}

		return View::factory('admin/page/fragments/breadcrumbs')->set('pages', $pages);
	}
}
