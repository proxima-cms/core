<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Assets_Index extends View_Model {

	public function render($file = NULL)
	{
		$data = $this->request;

		$this->direction				 = Arr::get($data, 'direction', 'asc');
		$this->reverse_direction = $this->direction === 'asc' ? 'desc' : 'asc';
		$this->order_by					 = Arr::get($data, 'sort', 'date');
		$this->type							 = Arr::get($data, 'type', 'all');
		$this->subtype					 = Arr::get($data, 'subtype', 'all');
		$this->filter						 = Arr::get($data, 'filter');
		$this->items_per_page		 = 18; 
		$this->links						 = $this->get_filter_links($this->direction);

		// Adjust the order_by value.
		switch($this->order_by)
		{
			case 'type':
				$this->order_by = 'mimetype_id';
				break;
			default:
				break;
		}

		return parent::render($file);	
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
	
	// Get the total amount of filtered assets.
	public function var_total()
	{
		return ORM::factory('asset')
			->join('mimetypes')
			->on('asset.mimetype_id', '=', 'mimetypes.id')
			->filter($this->filter)
			->search($this->search)
			->count_all();
	}

	// Generate the pagination.
	public function var_pagination()
	{
		return Pagination::factory(array(
			'total_items'		 => $this->total,
			'items_per_page' => $this->items_per_page,
			'view'					 => 'admin/pagination/asset_links'
		));
	}

	// Return the filtered assets.
	public function var_assets()
	{
		return ORM::factory('asset')
			->join('mimetypes')
			->on('asset.mimetype_id', '=', 'mimetypes.id')
			->order_by($this->order_by, $this->direction)
			->limit($this->pagination->items_per_page)
			->offset($this->pagination->offset)
			->filter($this->filter)
			->search($this->search)
			->find_all();
	}
}
