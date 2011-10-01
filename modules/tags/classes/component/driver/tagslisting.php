<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_TagsListing extends Component_Component {

	public function render()
	{
  	$pages = ORM::factory('site_page')->find_all();

		return View::factory('themes/default/components/tags/taglisting/list')
			->set('pages', $pages);
	}
}
