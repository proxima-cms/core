<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_HeaderScripts extends Component_Component {

	public $view_path = 'themes/default/components/site/headerscripts';

	public function render()
	{
		return View::factory($this->view_path)
			->set('styles', Kohana::$config->load("assets.default.style"))
			->set('scripts', Kohana::$config->load("assets.default.script"))
			->render();
	}
}
