<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Master extends View_Model_Master {

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

		parent::__construct($file, $data, $assets);
	}
}
