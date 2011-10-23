<?php defined('SYSPATH') or die('No direct script access.');
	
abstract class Controller_Base extends Controller_Template {
 
	public $template = 'page/master_page';
	
	public $auto_render = TRUE;

	protected $auth_required = FALSE;

	public function before()
	{
		Kohana::$config->attach(new Config_Database);

		$this->authenticate();

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

	public function authenticate()
	{
		// If this page is secured and the user is not logged in (or doesn't match role), then redirect to the signin page
		if ($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)
		{
			Message::set(Message::ERROR, __('You need to be signed in to do that.'));
			
			// Set the return path so user is redirect back to this page after successful sign in
			$uri = 'user/signin?return_to=' . $this->request->uri();

			$this->request->redirect($uri);
		}
	}

	private function profiler($content)
	{
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
