<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_PageNav extends Component_Component {

	protected $view_path = 'themes/default/components/pages/pagenav/nav';

	protected $_default_config = array(
		'parent_id' => 1
	);

	public function render()
	{
		$pages = ORM::factory('site_page')
			->where('parent_id', '=', $this->_config['parent_id'])
			->find_all();

    return View::factory($this->view_path)
			->set('pages', $pages)
			->render();
	}
}
