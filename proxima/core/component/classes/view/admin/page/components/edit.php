<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Components_Edit extends View_Model {
	
	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);
	}
	
	// Return the total amount of filtered items
	public function var_total()
	{
		//return ORM::factory($this->model)->count_all();
	}


	// Return the pagination
	public function var_pagination()
	{
		//return Pagination::factory(array(
		//	'total_items'    => $this->view->total,
		//	'items_per_page' => $this->view->items_per_page,
		//	'view'           => 'admin/pagination/links'
		//)); 
	}


}
