<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Page_List extends Component_Component {

	protected $_default_config = array(
		'parent_id' => 1
	);

	public function render()
	{
    $cache_key = 'page-listing-'.$this->_config['parent_id'];

    if (!$pages = Cache::instance()->get($cache_key))
    {   
			$pages_result = ORM::factory('site_page')
				->where('parent_id', '=', $this->_config['parent_id'])
				->find_all();

      $pages = array();

      foreach($pages_result as $page)
      {   
        $pages[] = (object) $page->as_array();
      }   

      Cache::instance()->set($cache_key, $pages);
    }   

    return View::factory(Theme::path('components/pages/list/list'))
			->set('pages', $pages)
			->render();
	}
}
