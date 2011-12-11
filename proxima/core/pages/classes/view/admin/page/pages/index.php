<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Pages_Index extends View_Model_Admin {

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);

		// Add scripts to master page view
		Page_View::instance()
			->scripts(array(Core::path('pages/media/js/admin/pages.js')));
	}
}
