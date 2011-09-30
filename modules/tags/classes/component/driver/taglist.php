<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_TagList extends Component_Component {

	protected $_default_config = array(
		'parent_id' => 1
	);

	public function render()
	{
		$tree_path = 'themes/default/components/pages/pagelist/tree';

  	$tags = ORM::factory('tag')->find_all();

		return View::factory('themes/default/components/tags/taglist/tags')
			->set('tags', $tags);
	}
}
