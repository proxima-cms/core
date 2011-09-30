<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_PageBody extends Component_Component {

	protected $view_path = 'themes/default/components/pages/pagebody/body';

	public function render()
	{
    return View::factory($this->view_path)->render();
	}
}
