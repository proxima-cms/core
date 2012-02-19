<?php defined('SYSPATH') or die('No direct access allowed.');

class Proxima_Component_Driver_Footer_Scripts extends Component_Component {

	public function render()
	{
		$scripts = array();
		//foreach($config_scripts = Theme::config('media.scripts') as $script)
		//{
		//	$scripts[] = 'application/views/'.$script;
		//}

		//if (Kohana::$environment !== Kohana::DEVELOPMENT)
		//{
		//	$scripts = array(Compress::instance()->scripts($scripts));
		//}

		return View::factory('components/footer/scripts')->render();
	}
}
