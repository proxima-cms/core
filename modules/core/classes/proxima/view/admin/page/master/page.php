<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Master_Page extends View_Model_Master {

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct();

		$request = Request::current();

		$this
			->styles(array(
				(array) Kohana::$config->load('admin/media.styles'), 
				(array) Kohana::$config->load('admin/'.$request->controller().'.styles')
			))  
			->scripts(array(
				(array) Kohana::$config->load('admin/media.scripts'),
				(array) Kohana::$config->load('admin/'.$request->controller().'.scripts'),
			))  
			->paths(array(
				(array) Kohana::$config->load('admin/media.paths'),
				(array) Kohana::$config->load('admin/'.$request->controller().'.paths'),
			));
	}

}
