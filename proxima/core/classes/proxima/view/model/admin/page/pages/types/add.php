<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Pages_Types_Add extends View_Model_Admin {

	public function var_templates()
	{
		$templates = array();

		foreach(Kohana::list_files('views/templates') as $key => $template)
		{
			$templates[basename($key)] = basename($key);
		}

		return $templates;
	}
}
