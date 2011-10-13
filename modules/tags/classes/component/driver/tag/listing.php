<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Tag_Listing extends Component_Component {

	public function render()
	{
  	$pages = ORM::factory('site_page')->find_all();

		return View::factory(Theme::path('components/tags/taglisting/list'))
			->set('pages', $pages)
			->render();
	}
}
