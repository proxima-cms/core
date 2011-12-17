<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Page View library. Handles request view model rendering
 *
 */
class Page_View {

	protected static $auto_render = TRUE;

	// Page_View instances
	protected static $_instance;

	/**
	 * Singleton pattern
	 *
	 * @return Auth
	 */
	public static function instance($data = array())
	{
		if ( ! isset(static::$_instance))
		{

			static::$_instance = new static($data);
		}

		return static::$_instance;
	}

	/**
	 * Loads datauration options and creates the page view template
	 *
	 * @return  void
	 */
	public function __construct($data)
	{
		if ( ! isset($data['view_model']))
		{
			throw new Exception('A page view model needs to be specified.');
		}

		if ( isset($data['auto_render'])) 
		{
			static::$auto_render = $data['auto_render'];
		}

		$this->template = View_Model::factory($data['view_model']);
	}

	/**
	 * Replaces profiler placeholder data with actual profiler data in a string
	 *
	 * @return  string
	 */
	private function profiler($content)
	{
		$profiler = Profiler::application();

		list($time, $memory) = array_values( $profiler['current'] );

		// Prep the data
		$data = array(
			'{memory_usage}'   => Text::bytes($memory),
			'{execution_time}' => round($time, 3).'s',
			'{profiler}'       => Kohana::$environment === Kohana::DEVELOPMENT ? View::factory('profiler/stats') : ''
		);

		// Replace the placeholders with data
		return strtr( (string) $content, $data);
	}
	
	/**
	 * Renders the page view
	 *
	 * @return  Page_View
	 */
	public function render()
	{
		$request = Request::current();

		// If it's an AJAX or HMVC request then only render the INNER template
		if ($request->is_ajax() OR Request::initial() !== $request)
		{
			$request->response()->body($this->template->content);
		}
		// Else render the master template
		else if (static::$auto_render === TRUE && isset($this->template))
		{
			// Render the master template
			$request->response()->body($this->profiler($this->template));
		}  
	}

	public function __call($name, $arguments)
	{
		$func = !method_exists($this, $name)
			? array($this->template, $name) 
			: array($this, $name);

		call_user_func_array($func, $arguments);

		return $this;
	}
} // End Page_View
