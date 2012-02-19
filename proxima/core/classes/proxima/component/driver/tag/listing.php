<?php defined('SYSPATH') or die('No direct access allowed.');

class Proxima_Component_Driver_Tag_Listing extends Component_Component {

	protected $_default_config = array(
		'items_per_page'	=> 10,
		'tag_slug'        => NULL
	);

	public function render()
	{
		$tag_slug = $this->config('tag_slug');

		if ($tag_slug === NULL)
		{
			throw new HTTP_Exception_404('Page not found.');
		}

		$cache_key = 'tag-list-'.$tag_slug;

		if (!$listing_html = Cache::instance()->get($cache_key))
		{
			$tag = ORM::factory('tag')
				->where('slug', '=', $tag_slug)
				->find();

			if (!$tag->loaded())
			{
				throw new HTTP_Exception_404('Page not found.');
			}

			$pages = ORM::factory('site_page')
				->join('tags_pages')
				->on('tags_pages.page_id', '=', 'site_page.id')
				->where('tags_pages.tag_id', '=', $tag->id);

			// Get the total amount of items in the table
			$total = $pages->count_all();

			// Generate the pagination values
			$pagination = Pagination::factory(array(
				'total_items' => $total,
				'items_per_page' => $this->_config['items_per_page'],
				'view' => 'components/pages/list/pagination'
			));

			// Get the items
			$items = ORM::factory('site_page')
				->join('tags_pages')
				->on('tags_pages.page_id', '=', 'site_page.id')
				->where('tags_pages.tag_id', '=', $tag->id)
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

			$listing_html = View::factory('components/tags/taglisting/list')
				->set('pages', $pages)
				->render();

			Cache::instance()->set($cache_key, $listing_html);
		}

		return $listing_html;
	}
}
