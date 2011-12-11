<?php defined('SYSPATH') or die('No direct script access.');
	
abstract class Controller_Admin_Base extends Controller_Base {
 
	// Only users with role 'admin' can view this controller
	protected $auth_required = 'admin';

	// Set the default admin master template
	public $master_template = 'admin/page/master/page';

	public function before()
	{
		parent::before();

		// Set the global admin page config
		Page_View::instance()
			->styles(array(
				(array) Kohana::$config->load('admin/media.styles'), 
				(array) Kohana::$config->load('admin/'.$this->request->controller().'.styles')
			))
			->scripts(array(
				(array) Kohana::$config->load('admin/media.scripts'), 
				(array) Kohana::$config->load('admin/'.$this->request->controller().'.scripts'),
			))
			->paths(array(
				(array) Kohana::$config->load('admin/media.paths'),
				(array) Kohana::$config->load('admin/'.$this->request->controller().'.paths'),
			))
			->param(
				$this->request->param()
			);
	}
	
} // End Controller_Admin_Base
