<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Users_Index extends View_Model_Admin_Page_Index {
	
	protected $model = 'user';

	protected $order_by = 'username';

}
