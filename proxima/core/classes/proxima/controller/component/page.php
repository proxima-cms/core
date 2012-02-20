<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Component_Page extends Controller_Component {

	public function action_nav()
	{
		$data = array_merge(array('parent_id' => 1), $this->request->query());

		$cache_key = 'page-nav-'.$data['parent_id'];

		if (!$pages = Cache::instance()->get($cache_key))
		{
			$pages_result = ORM::factory('site_page')
				->where('parent_id', '=', $data['parent_id'])
				->where('visible_in_nav', '=', 1)
				->find_all();

			$pages = array();
			foreach($pages_result as $page)
			{
				$pages[] = (object) $page->as_array();
			}

			Cache::instance()->set($cache_key, $pages);
		}

		$this->template->content = View_Model::factory('components/page/nav/nav', array('pages' => $pages));
	}
}
