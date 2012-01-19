<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin extends View_Model {

	protected $breadcrumbs = array();

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);

		$controller = Request::current()->controller();

		$this->breadcrumbs(array(
			array('admin', Route::get('admin')->uri()),
			array($controller, Route::get('admin')->uri(array('controller' => $controller)))
		));
	}

	public function breadcrumb(array $breadcrumb)
	{
		$this->breadcrumbs[] = $breadcrumb;
	}

	public function breadcrumbs(array $breadcrumbs)
	{
		$this->breadcrumbs += $breadcrumbs;
	}

	public function var_breadcrumbs()
	{
		$pages = array();

		foreach($this->breadcrumbs as $breadcrumb)
		{
			$pages[] = array(
				'title' => ucfirst($breadcrumb[0]),
				'url'   => URL::site($breadcrumb[1])
			);
		}

		return View::factory('admin/page/fragments/breadcrumbs')
			->set('pages', $pages);
	}
}
