<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model {

	protected $_view;

	protected $_file;

	protected $_assets;

	public function __construct($file = NULL, array $data = NULL, Assets $assets = NULL)
	{
		if ($file === NULL)
		{
			if ($this->_file === NULL)
			{
				// Get the view name from the class name.
				$class = explode('_', get_class($this));

				array_shift($class);

				$file = strtolower(implode('/', $class));
			}
			else
			{
				$file = $this->_file;
			}
		}

		$this->_assets = $assets;

		$this->_file = str_replace('view/model/', '', $file);

		$this->_view = new View($this->_file, $data);
	}

	public static function factory($file = NULL, array $data = NULL)
	{
		$class = 'Proxima_View_Model_' . strtr($file, '/', '_');

		return new $class($file, $data);
	}

	public function bind($key, & $value)
	{
		$this->_view->bind($key, $value);

		return $this;
	}

	public static function bind_global($key, & $value)
	{
		$this->_view->bind_global($key, $value);

		return $this;
	}

	public function render()
	{
		// Set the assets var
		if ($this->_assets !== NULL)
		{
			$this->_view->set('assets', $this->_assets);
		}

		// Add view-model variable methods as view variables.
		foreach(get_class_methods($this) as $method)
		{
			preg_match("/^var_(.*?)$/", $method, $matches);

			if (count($matches))
			{
				$this->_view->set($matches[1], $this->{$method}());
			}
		}

		// Render the view.
		return $this->_view->render();
	}

	public function set($key, $value = NULL)
	{
		$this->_view->set($key, $value);

		return $this;
	}

	public function set_filename($file)
	{
		$this->_view->set_filename($file);

		return $this;
	}

	public static function set_global($key, $value = NULL)
	{
		$this->_view->set_global($key, $value);

		return $this;
	}

	public function __get($key)
	{
		return $this->_view->{$key};
	}

	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	public function __isset($key)
	{
		return isset($this->_view->{$key});
	}

	public function __unset($key)
	{
		unset($this->_view->{$key});
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
