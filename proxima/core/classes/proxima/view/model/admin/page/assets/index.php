<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Assets_Index extends View_Model_Admin {

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);

		$data = $data['request'];

		$this->set(array(
				'direction'      => Arr::get($data, 'direction', 'asc'),
				'folder'         => Arr::get($data, 'folder'),
				'order_by'       => Arr::get($data, 'sort', 'date'),
				'type'           => Arr::get($data, 'type', 'all'),
				'subtype'        => Arr::get($data, 'subtype', 'all'),
				'filter'         => Arr::get($data, 'filter'),
				'folder'         => Arr::get($data, 'folder'),
				'items_per_page' => 18,
			))
			->set(array(
				'reverse_direction' => $this->direction === 'asc' ? 'desc' : 'asc',
				'links' => $this->get_filter_links($this->direction)
			));

		// Adjust the order_by value.
		switch($this->order_by)
		{
			case 'type':
				$this->order_by = 'mimetype_id';
				break;
			default:
				break;
		}
	}

	public function get_filter_links($direction = NULL, $link = NULL)
	{
		$link = $link ?: Request::current()->uri();

		$query = Request::current()->query();

		$query['direction'] = $direction;

		$link .= '?' ;

		return array(
			'links' => array(
				'all' => $link . http_build_query(array('direction' => $query['direction'])),
				'img' => $link . http_build_query(array_merge($query, array('filter' => 'subtype-image'))),
				'doc' => $link . http_build_query(array_merge($query, array('filter' => 'type-pdf|doc|txt'))),
				'arc' => $link . http_build_query(array_merge($query, array('filter' => 'type-tar|zip|rar')))
			),
			'cur_url' => $link . http_build_query($query)
		);
	}

	// Return the total amount of filtered assets.
	public function var_total()
	{
		return ORM::factory('asset')
			->join('mimetypes')
			->on('asset.mimetype_id', '=', 'mimetypes.id')
			->filter($this->filter)
			->search($this->search)
			->count_all();
	}

	// Return the pagination.
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
		$assets = ORM::factory('asset')
			->join('mimetypes')
			->on('asset.mimetype_id', '=', 'mimetypes.id')
			->order_by($this->order_by, $this->direction)
			->limit($this->pagination->items_per_page)
			->offset($this->pagination->offset)
			->filter($this->filter)
			->search($this->search);

		if ($this->folder !== NULL)
		{
			$assets->where('folder_id', '=', $this->folder);
		};

		return $assets->find_all();
	}

	// Return the current folder.
	public function var_cur_folder()
	{
		return (int) Request::current()->query('folder');
	}

	// Returns the current url with the 'folder' query string param as an underscore.js template.
	public function var_folder_uri_template()
	{
		$links = $this->links;

		$query = Request::current()->query();

		$query['folder'] = '<%= folder %>';

		return urldecode(URL::site(Request::current()->uri() . '?' . http_build_query($query)));
	}

	// Return a folder tree select array.
	public function var_folders()
	{
		return ORM::factory('asset_folder')->tree_select(4, 0, array(__('None')), 0, 'name');
	}

	// Return a folder tree select array, with filter url strings for the <option> values.
	public function var_folders_with_uris()
	{
		$links = $this->links;

		$uri = Request::current()->uri();

		$query = Request::current()->query();

		return ORM::factory('asset_folder')->tree_select(4, 0, array(__('None')), 0, 'name',
			function($folder) use ($links, $uri, $query)
			{
				$query['folder'] = $folder->id;

				return URL::site($uri . '?' . http_build_query($query));
			}
		);
	}
}
