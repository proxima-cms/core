<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Component_Page extends Controller_Component {

	public function action_nav()
	{
		// Merge in the default request data
		$data = array_merge(array('parent_id' => 1), $this->request->query());

		$this->template->content = View_Model::factory('components/page/nav/nav', $data);
	}
}
