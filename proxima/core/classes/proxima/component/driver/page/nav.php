<?php defined('SYSPATH') or die('No direct access allowed.');

class Proxima_Component_Driver_Page_Nav extends Component_Component {

	protected $_default_config = array(
		'parent_id' => 1
	);

	public function render()
	{
		$cache_key = 'page-nav-'.$this->_config['parent_id'];

		if (!$pages = Cache::instance()->get($cache_key))
		{
			$pages_result = ORM::factory('site_page')
				->where('parent_id', '=', $this->_config['parent_id'])
				->where('visible_in_nav', '=', 1)
				->find_all();

			$pages = array();

			foreach($pages_result as $page)
			{
				$pages[] = (object) $page->as_array();
			}

			Cache::instance()->set($cache_key, $pages);
		}

		return View::factory('components/pages/nav/nav')
			->set('pages', $pages)
			->render();
	}
}
