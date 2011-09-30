<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_PageList extends Component_Component {

	protected $_default_config = array(
		'parent_id' => 1
	);

	public function render()
	{
		$tree_path = 'themes/default/components/pages/pagelist/tree';

    return ORM::factory('page')->tree_list_html($tree_path, $this->_config['parent_id']);
	}
}
