<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Master extends View_Model {

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
	 * Set the master page title
	 */
	public function title($title)
	{
		$this->set('title', $title);

		return $this;
	}

	/**
	 * Set the master page inner template (can be an instance of View or View_Model)
	 */
	public function content($view)
	{
		$this->set('content', $view);

		return $this;
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
}
