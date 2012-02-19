<?php defined('SYSPATH') or die('No direct access allowed.');

class Proxima_Component_Driver_Page_Body extends Component_Component {

	public function render()
	{
		return View::factory('components/pages/body/body')
			->set($this->_config)
			->render();
	}
}
