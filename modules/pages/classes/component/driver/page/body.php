<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Page_Body extends Component_Component {

	protected $view_path = 'themes/default/components/pages/body/';

	public function render()
	{
    return View::factory($this->view_path.'body')->render();
	}
}
