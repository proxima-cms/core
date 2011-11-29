<?php defined('SYSPATH') or die('No direct script access.');

class View_Model {

	protected $view;

	protected $file;

	public function __construct($file = NULL, array $data = NULL)
	{
		if ($file === NULL)
		{
			if ($this->file === NULL)
			{
				// Get the view name from the class name.
				$class = explode('_', get_class($this));
				array_shift($class);
				$file = strtolower(implode('/', $class));
			}
			else
			{
				$file = $this->file;
			}
		}

		$this->view = new View($file, $data);
	}

	public static function factory($file = NULL, array $data = NULL)
	{
		$class = 'View_'.strtr($file, '/', '_');
		
		return new $class($file, $data);
	}

	public function bind($key, & $value)
	{
		return $this->view->bind($key, $value);
	}
	
	public static function bind_global($key, & $value)
	{
		$this->view->bind_global($key, $value);
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

	public function set($key, $value = NULL)
	{
		return $this->view->set($key, $value);
	}

	public function set_filename($file)
	{
		return $this->view->set_filename($file);
	}

	public static function set_global($key, $value = NULL)
	{
		$this->view->set_global($key, $value);
	}

	public function & __get($key)
	{
		return $this->view->{$key};
	}
	
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	public function __isset($key)
	{
		return isset($this->view->{$key});
	}

	public function __unset($key)
	{
		unset($this->view->{$key});
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
