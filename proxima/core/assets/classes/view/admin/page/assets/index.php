<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Assets_Index extends View_Model_Admin {

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);

		$data = $this->view->request;

		$this->view
			->set(array(
				'direction'      => Arr::get($data, 'direction', 'asc'),
				'order_by'       => Arr::get($data, 'sort', 'date'),
				'type'           => Arr::get($data, 'type', 'all'),
				'subtype'        => Arr::get($data, 'subtype', 'all'),
				'filter'         => Arr::get($data, 'filter'),
				'items_per_page' => 18,
			))
			->set(array(
				'reverse_direction' => $this->view->direction === 'asc' ? 'desc' : 'asc',
				'links' => $this->get_filter_links($this->view->direction)
			));

		// Adjust the order_by value.
		switch($this->view->order_by)
		{
			case 'type':
				$this->view->order_by = 'mimetype_id';
				break;
			default:
				break;
		}
	}
	
	public function get_filter_links($direction = NULL)
	{
		$link = 'admin/assets?direction='.$direction;

		return array(
			'links' => array(
				'all' => $link,
				'img' => $link.'&filter=subtype-image',
				'doc' => $link.'&filter=type-pdf|doc|txt',
				'arc' => $link.'&filter=type-tar|zip|rar'
			),	
			'cur_url' => urldecode(Request::current()->uri() . URL::query())
		);
	}
	
	// Return the total amount of filtered assets.
	public function var_total()
	{
		return ORM::factory('asset')
			->join('mimetypes')
			->on('asset.mimetype_id', '=', 'mimetypes.id')
			->filter($this->view->filter)
			->search($this->view->search)
			->count_all();
	}

	// Return the pagination.
	public function var_pagination()
	{
		return Pagination::factory(array(
			'total_items'		 => $this->view->total,
			'items_per_page' => $this->view->items_per_page,
			'view'					 => 'admin/pagination/asset_links'
		));
	}

	// Return the filtered assets.
	public function var_assets()
	{
		return ORM::factory('asset')
			->join('mimetypes')
			->on('asset.mimetype_id', '=', 'mimetypes.id')
			->order_by($this->view->order_by, $this->view->direction)
			->limit($this->view->pagination->items_per_page)
			->offset($this->view->pagination->offset)
			->filter($this->view->filter)
			->search($this->view->search)
			->find_all();
	}
}
