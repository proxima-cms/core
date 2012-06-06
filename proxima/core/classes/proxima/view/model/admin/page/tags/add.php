<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Tags_Add extends View_Model_Admin {
	
	protected $model = 'tag';

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);


		//$this->master_view_model->breadcrumb(array('add', Request::current()->uri()));
	}

}
