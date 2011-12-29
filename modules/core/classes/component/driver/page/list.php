<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Page_List extends Component_Component {

	protected $_default_config = array(
		'parent_id'				=> 1,
		'items_per_page'	=> 10
	);

	public function render()
	{
		$cache_key = 'page-listing-'.$this->_config['parent_id'].'-'.Arr::get($_REQUEST, 'page', '');

		if (!$listing_html = Cache::instance()->get($cache_key))
		{		
			$pages = ORM::factory('site_page')
				->where('parent_id', '=', $this->_config['parent_id']);

			// Get the total amount of items in the table
			$total = $pages->count_all();

			// Generate the pagination values
			$pagination = Pagination::factory(array(
				'total_items' => $total,
				'items_per_page' => $this->_config['items_per_page'],
				'view' => Theme::path('components/pages/list/pagination')
			)); 

			// Get the items
			$items = ORM::factory('site_page')
				->where('parent_id', '=', $this->_config['parent_id'])
				->limit($pagination->items_per_page)
				->offset($pagination->offset)
				->find_all();

			$tag_keys = array('id', 'user_id', 'name', 'slug', 'date');
			$pages = array();

			foreach($items as $page)
			{		
				$tags = array();
				foreach(explode(',', $page->tags) as $tag)
				{
					$tag_data = explode('|', $tag);

					if (count($tag_data) === count($tag_keys))
					{
						$tags[] = (object) array_combine($tag_keys, $tag_data);
					}
				}

				$page = (object) $page->as_array();
				$page->tags = $tags;

				$pages[] = $page;
			}		

			$listing_html = View::factory(Theme::path('components/pages/list/list'))
				->set('pages', $pages)
				->set('page_links', $pagination->render())
				->render();

			Cache::instance()->set($cache_key, $listing_html);
		}

		return $listing_html;
	}

}
