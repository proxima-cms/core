<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Master extends View_Model_Master {

	protected $breadcrumbs = array();

	public function __construct($file = NULL, array $data = NULL, Assets $assets = NULL)
	{
		$request = Request::current();

		// Get the default master assets
		$assets = new Assets(Kohana::$config->load('assets/admin'));

		// Get the controller specific assets
		$assets->config(Kohana::$config->load('assets/admin/'.$request->controller()));

		// Load the master group
		$assets->group('master');

		// Load the action specific group
		$assets->group($request->action());

		$controller = Request::current()->controller();

		$this->breadcrumbs(array(
			array('admin', Route::get('admin')->uri()),
			array($controller, Route::get('admin')->uri(array('controller' => $controller)))
		));
		
		parent::__construct($file, $data, $assets);
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
				'url'		=> URL::site($breadcrumb[1])
			);
		}

		return View::factory('admin/page/fragments/breadcrumbs')
			->set('pages', $pages);
	}

}
