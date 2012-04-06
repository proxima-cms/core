<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Users_List extends View_Model_Admin {

	protected $order_by = 'username';

	protected $model = 'user';

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);

		$this->set(array(
				'direction'      => Arr::get($data, 'direction', 'asc'),
				'order_by'       => Arr::get($data, 'sort', $this->order_by),
				'items_per_page' => 18,
			));
	}

	// Return the total amount of filtered items
	public function var_total()
	{
		return ORM::factory($this->model)->count_all();
	}

	// Return the pagination
	public function var_pagination()
	{
		return Pagination::factory(array(
			'total_items'		 => $this->total,
			'items_per_page' => $this->items_per_page,
			'view'					 => 'admin/pagination/links'
		));
	}

	// Return the filtered items
	public function var_items()
	{
		$plural = Inflector::plural($this->by);

		return ORM::factory($this->model)
			->join($plural.'_users')
				->on($plural.'_users.user_id', '=', 'user.id')
			->join($plural)
				->on($plural.'_users.'.$this->by.'_id', '=',  $plural.'.id')
			->where($plural.'_users.'.$this->by.'_id', '=', $this->id)
			->order_by($this->order_by, $this->direction)
			->limit($this->pagination->items_per_page)
			->offset($this->pagination->offset)
			->find_all();
	}
}
