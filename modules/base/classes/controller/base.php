<?php defined('SYSPATH') or die('No direct script access.');
	
abstract class Controller_Base extends Controller_Template {
 
	public $template = 'page/master_page';
	
	public $auto_render = TRUE;

	protected $auth_required = FALSE;

	public function before()
	{
	
		// FIME: Load the database config driver
		//Kohana::$config->attach(new Config_Database);

		parent::before();

		if ($this->auto_render === TRUE)
		{
			$this->template->title = NULL;
			$this->template->content = NULL;
			$this->template->environment = Kohana::$environment == Kohana::DEVELOPMENT ? 'development' : 'production';
		}
	}

	public function after()
	{
		if (Request::current()->is_ajax() OR $this->request !== Request::current())
		{
			$this->response->body($this->template->content);
		} 
		else 
		{
			if ($this->auto_render === TRUE AND $this->template->content === NULL)
			{
				// Try auto-load a view
				try
				{
					$this->template->content = View::factory('page/'.$this->request->controller().'/'.$this->request->action());
				}
				catch(VIEW_EXCEPTION $e) { }
			}

			parent::after();

			// Add profiler information to template content
			$this->response->body( $this->profiler( $this->request->response() ) );
		}
	}

	private function profiler($content)
	{
		// Load the profiler
		$profiler = Profiler::application();

		list($time, $memory) = array_values( $profiler['current'] );

		// Prep the data
		$data = array(
			'{memory_usage}' => Text::bytes($memory),
			'{execution_time}' => round($time, 3).'s',
			'{profiler}' => Kohana::$environment === Kohana::DEVELOPMENT ? View::factory('profiler/stats') : ''
		);

		// Replace the placeholders with data
		return strtr( (string) $content, $data);
	}

} // End Controller_Base
