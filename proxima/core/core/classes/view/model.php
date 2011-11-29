<?php defined('SYSPATH') or die('No direct script access.');

class View_Model {

	protected $view;

	public function __construct($file = NULL, array $data = NULL)
	{
		$this->view = new View($file, $data);
	}

	public static function factory($file = NULL, array $data = NULL)
	{
		// Return a raw view object if no template is specified.
		if ($file === FALSE)
		{
			return new View(FALSE, $data);
		}
			
		$class = 'View_'.strtr($file, '/', '_');
		
		return new $class($file, $data);
	}

	public function bind($key, & $value)
	{
		return $this->view->bind($key, $value);
	}

	public function set($key, $value = NULL)
	{
		return $this->view->set($key, $value);
	}

	public function render()
	{
		// Add view-model variable methods as view variables.
		foreach(get_class_methods($this) as $method)
		{
			preg_match("/^var_(.*?)$/", $method, $matches);

			if (count($matches))
			{
				$this->view->set($matches[1], $this->{$method}());
			}
		}

		// Render the view.
		return $this->view->render();
	}

	public function __toString()
	{
		try
		{
			return $this->render();
		}
		catch(Exception $e)
		{
			// Display the exception message
			Kohana_Exception::handler($e);

			return '';
		}
	}
}
