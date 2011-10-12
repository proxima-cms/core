<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Head_Scripts extends Component_Component {

	public function render()
	{
		$styles = array();
		foreach($config_styles = Theme::config('media.styles') as $style)
		{
			$styles[] = 'application/views/'.Theme::path($style);
		}

    if (Kohana::$environment !== Kohana::DEVELOPMENT)
    {   
      $styles = array(Compress::instance()->scripts($styles));
    } 

		return View::factory(Theme::path('components/head/scripts'))
			->set('styles', $styles)
			->render();
	}
}
