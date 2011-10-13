<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Page_Body extends Component_Component {

	public function render()
	{
    return View::factory(Theme::path('components/pages/body/body'))->render();
	}
}
