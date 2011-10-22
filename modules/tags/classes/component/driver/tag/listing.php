<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Tag_Listing extends Component_Component {

	public function render()
	{
		$tag_slug = Request::current()->param('name');
	
		if ($tag_slug === NULL)
		{
			$tag_slug = Request::current()->query('name');
		}

		$cache_key = 'tag-list-'.$tag_slug;

		if (!$listing_html = Cache::instance()->get($cache_key))
		{		
			$pages_cache = ORM::factory('page');

			if ($tag_slug !== NULL)
			{
				$tag = ORM::factory('tag')
					->where('slug', '=', $tag_slug)
					->find();
		
				if (!$tag->loaded())
				{
					throw new HTTP_Exception_404('Page not found.');
				}
				
				$pages = $pages_cache
					->join('tags_pages')
					->on('tags_pages.page_id', '=', 'page.id')
					->where('tags_pages.tag_id', '=', $tag->id);
			}

			$listing_html = View::factory(Theme::path('components/tags/taglisting/list'))
				->set('pages', $pages->find_all())
				->render();
		
			Cache::instance()->set($cache_key, $listing_html);
		}		

		return $listing_html;
	}
}
