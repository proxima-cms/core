<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Page View library. Handles page view logic through view models.
 *
 */
class Page_View {

	// Page_View instances
	protected static $_instance;

	/**
	 * Singleton pattern
	 *
	 * @return Auth
	 */
	public static function instance($config = array())
	{
		if ( ! isset(Page_View::$_instance))
		{
			Page_View::$_instance = new Page_View($config);
		}

		return Page_View::$_instance;
	}

	/**
	 * Loads configuration options and creates the page view template
	 *
	 * @return  void
	 */
	public function __construct($config)
	{
		$this->_config = $config;
		
		$this->template = View_Model::factory($this->_config['view']);
	}

	protected $_config;

	/**
	 * Sets the page title
	 *
	 * @return  Page_View
	 */
	public function title($title = NULL)
	{
		$this->template->set('title', $title);

		return $this;
	}
	
	/**
	 * Sets the page content
	 *
	 * @return  Page_View
	 */
	public function content($content = NULL)
	{
		$this->template->set('content', $content);

		return $this;
	}
	
	/**
	 * Sets a page config group
	 *
	 * @return  Page_View
	 */
	private function config($key, $initial, $items)
	{
		
		if (!isset($this->_config[$key]))
		{
			$this->_config[$key] = $initial;
		}
	
		foreach($items as $item)
		{
			if (!is_array($item))
			{
				array_push($this->_config[$key], $item);
			}
			else
			{
				$this->_config[$key] = array_merge($item, $this->_config[$key]);
			}
		}

		return $this;
	}
	
	/**
	 * Sets the page styles
	 *
	 * @return  Page_View
	 */
	public function styles($styles = array())
	{
		$this->config('styles', array(), $styles);

		return $this;
	}
	
	/**
	 * Sets the page scripts
	 *
	 * @return  Page_View
	 */
	public function scripts($scripts = array())
	{
		$this->config('scripts', array(), $scripts);

		return $this;
	}
	
	/**
	 * Sets the page paths
	 *
	 * @return  Page_View
	 */
	public function paths($paths = array())
	{
		$this->config('paths', array(), $paths);

		return $this;
	}

	/**
	 * Sets the page parameters
	 *
	 * @return  Page_View
	 */
	public function param($param = array())
	{
		$this->config('param', array(), $param);

		return $this;
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

		// If it's an AJAX or HMVC request then only render the inner template
		if ($request->is_ajax() OR Request::initial() !== $request)
		{
			// Only render the inner page content
			$request->response()->body($this->template->content);
		}
		// Else render the master template
		else if ($this->_config['render'] === TRUE && isset($this->template))
		{
			// Set the master page template data
			(isset($this->_config['styles']))
				AND $this->template->set('styles', $this->_config['styles']);

			(isset($this->_config['scripts']))
				AND $this->template->set('scripts', $this->_config['scripts']);

			(isset($this->_config['paths']))
				AND $this->template->set('paths', $this->_config['paths']);

			(isset($this->_config['param']))
				AND $this->template->set('param', $this->_config['param']);

			$this->template->set('environment', Kohana::$environment == Kohana::DEVELOPMENT ? 'development' : 'production');

			// Render the master template
			$request->response()->body($this->profiler($this->template));
		}  
	}

} // End Page_View
