<?php defined('SYSPATH') or die('No direct script access.');
	
abstract class Controller_Admin_Base extends Controller_Base {
 
	// Only users with role 'admin' can view this controller
	protected $auth_required = 'admin';

	// Set the default admin master view model
	public $view_model = 'admin/page/master/page';

} // End Controller_Admin_Base
