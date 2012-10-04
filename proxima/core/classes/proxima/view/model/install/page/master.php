<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Install_Page_Master extends View_Model_Master {

	public function __construct($file = NULL, array $data = NULL, Assets $assets = NULL)
	{
		// Load the install assets
		$assets = new Assets(Kohana::$config->load('assets/install'));
		$assets->group('page');

		return parent::__construct($file, $data, $assets);
	}
}
