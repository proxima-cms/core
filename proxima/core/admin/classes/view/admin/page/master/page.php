<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Master_Page extends View_Model {

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct();

		$request = Request::current();
		
		// Set the default admin page data
		$this
			->set('environment', Kohana::$environment == Kohana::DEVELOPMENT ? 'development' : 'production')
			->styles(array(
				(array) Kohana::$config->load('admin/media.styles'), 
				(array) Kohana::$config->load('admin/'.$request->controller().'.styles')
			))  
			->scripts(array(
				(array) Kohana::$config->load('admin/media.scripts'), 
				(array) Kohana::$config->load('admin/'.$request->controller().'.scripts'),
			))  
			->paths(array(
				(array) Kohana::$config->load('admin/media.paths'),
				(array) Kohana::$config->load('admin/'.$request->controller().'.paths'),
			))  
			->param(
				$request->param()
			);  
	}

	/**
	 * Sets the page title
	 *
	 * @return  Page_View
	 */
	public function title($title = NULL)
	{
		$this->set('title', $title);

		return $this;
	}
	
	/**
	 * Sets the page content
	 *
	 * @return  Page_View
	 */
	public function content($content = NULL)
	{
		$this->set('content', $content);

		return $this;
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
				$data = array_merge($item, $data);
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

}
