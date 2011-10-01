<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Footer_Scripts extends Component_Component {

	public $view_path = 'themes/default/components/footer/scripts';

	public function render()
	{
    $scripts = array(
      'application/views/themes/default/media/js/global.js'
    );  

    $scripts = Compress::instance()->scripts($scripts);

		return View::factory($this->view_path)
			->set('scripts', $scripts)
			->render();
	}
}
