<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Component_Tag extends Controller_Component {

	public function action_list()
	{
		$this->template->content = View_Model::factory('components/tags/taglist/tags');
	}
}
