<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Tag_List extends Component_Component {

	public function render()
	{
    $cache_key = 'tag-list-all';

    if (!$tags = Cache::instance()->get($cache_key))
    {   
      $tags_result = ORM::factory('tag')->find_all();
      $tags = array();

      foreach($tags_result as $tag)
      {   
        $tags[] = (object) $tag->as_array();
      }   
          
      Cache::instance()->set($cache_key, $tags);
    }   

		return View::factory(Theme::path('components/tags/taglist/tags'))
			->set('tags', $tags)
			->render();
	}
}
