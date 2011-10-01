<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Head_Scripts extends Component_Component {

	public $view_path = 'themes/default/components/head/scripts';

	public function render()
	{
    $styles = array(
      'application/views/themes/default/media/css/screen.css'
    );  

    $styles = Compress::instance()->styles($styles);

		return View::factory($this->view_path)
			->set('styles', $styles)
			->render();
	}
}
