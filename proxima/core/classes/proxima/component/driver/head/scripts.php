<?php defined('SYSPATH') or die('No direct access allowed.');

class Proxima_Component_Driver_Head_Scripts extends Component_Component {

	public function render()
	{
		$styles = array();
		foreach($config_styles = Theme::config('media.styles') as $style)
		{
			$styles[] = Theme::style_path($style);
		}

		if (Kohana::$environment !== Kohana::DEVELOPMENT)
		{
			$styles = array(Compress::instance()->styles($styles));
		}

		return View::factory('components/head/scripts')
			->set('styles', $styles)
			->render();
	}
}
