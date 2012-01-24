<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Redirects_Index extends View_Model_Admin_Page_Index {

	protected $model = 'redirect';

	protected $order_by = 'uri';
}
