<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Page_Install_Master_Install extends View_Model_Master {

	public function __construct($file = NULL, array $data = NULL, Assets $assets = NULL)
	{
		// Load the install assets
		$assets = new Assets(new Config_Group(Kohana::$config, 'assets', Kohana::$config->load('install.assets')));
		$assets->group('install');

		return parent::__construct($file, $data, $assets);
	}
}
