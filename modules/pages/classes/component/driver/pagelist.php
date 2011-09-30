<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_PageList extends Component_Component {

	protected $view_path = 'themes/default/components/pages/pagelist';

	protected $_default_config = array(
		'parent_id' => 1
	);

	public function render()
	{
		$pages = ORM::factory('site_page')->where('parent_id', '=', $this->_config['parent_id'])->find_all();

    return View::factory($this->view_path.'/list')
			->set('pages', $pages)
			->render();
	}
}
