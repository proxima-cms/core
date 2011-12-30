<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Users_List extends View_Model_Admin {
	
	protected $order_by = 'username';

	protected $model = 'user';

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);

		$this->view
			->set(array(
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
		return ORM::factory($this->model)
			->order_by($this->order_by, $this->direction)
			->limit($this->pagination->items_per_page)
			->offset($this->pagination->offset)
			->join('groups_users')
			->on('groups_users.user_id', '=', 'user.id')
			->join('groups')
			->on('groups_users.group_id', '=', 'groups.id')
			->where('groups_users.group_id', '=', $this->group_id)
			->find_all();
	}
}
