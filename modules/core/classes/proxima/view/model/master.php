<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Master extends View_Model {

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct();

		$request = Request::current();
		
		// Set the default admin page data
		$this
			->set('environment', Kohana::$environment == Kohana::DEVELOPMENT ? 'development' : 'production')
			->styles(array())  
			->scripts(array())  
			->paths(array())  
			->param(
				$request->param()
			);  
	}
	
	/**
	 * Sets a page data group
	 *
	 * @return  Page_View
	 */
	private function data($key, $items)
	{
		try
		{
			$data = $this->$key;
		}
		catch(Kohana_Exception $e)
		{
			$data = array();
		}
	
		foreach($items as $item)
		{
			if (!is_array($item))
			{
				array_push($data, $item);
			}
			else
			{
				$data = array_merge($data, $item);
			}
		}

		$this->$key = $data;

		return $this;
	}
	
	/**
	 * Sets the page styles
	 *
	 * @return  Page_View
	 */
	public function styles($styles = array())
	{
		$this->data('styles', $styles);

		return $this;
	}
	
	/**
	 * Sets the page scripts
	 *
	 * @return  Page_View
	 */
	public function scripts($scripts = array())
	{
		$this->data('scripts', $scripts);

		return $this;
	}
	
	/**
	 * Sets the page paths
	 *
	 * @return  Page_View
	 */
	public function paths($paths = array())
	{
		$this->data('paths', $paths);

		return $this;
	}

	/**
	 * Sets the page parameters
	 *
	 * @return  Page_View
	 */
	public function param($param = array())
	{
		$this->data('param', $param);

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
	 * Adds profiler data to the view string
	 *
	 * @return  string
	 */
	public function __toString()
	{
		return $this->profiler(parent::__toString());
	}

	/**
	 * Allow methods to be used for setting view variables
	 *
	 * @return  View_Admin_Page_Master_Page
	 */
	public function __call($name, $arguments)
	{
		if ( !method_exists($this, $name))
		{
			$this->set($name, current($arguments));

			return $this;
		}
	}
}
