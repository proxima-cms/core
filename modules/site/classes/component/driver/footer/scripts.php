<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Footer_Scripts extends Component_Component {

	public function render()
	{
		$scripts = array();
		foreach($config_scripts = Theme::config('media.scripts') as $script)
		{		
			$scripts[] = 'application/views/'.Theme::path($script);
		}		

		if (Kohana::$environment !== Kohana::DEVELOPMENT)
		{		
			$scripts = array(Compress::instance()->scripts($scripts));
		}		

		return View::factory(Theme::path('components/footer/scripts'))
			->set('scripts', $scripts)
			->render();
	}
}
