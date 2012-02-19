<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model {

	protected $_view;

	protected $_file;

	protected $_assets;

	protected $_assets_config;

	protected $_assets_group = 'page';

	public function __construct($file = NULL, array $data = NULL, Assets $assets = NULL)
	{
		// Get the view filename
		if ($file === NULL)
		{
			if ($this->_file === NULL)
			{
				$class = explode('_', get_class($this));

				// Remove 'view' and 'model' segments from the class name
				array_shift($class);
				array_shift($class);

				// Join the remaining class name segments into a view string
				$file = strtolower(implode('/', $class));
			}
			else
			{
				$file = $this->_file;
			}
		}

		// Set the view instance
		$this->_view = new View($file, $data);

		// If an assets instance exists then set it
		if ($assets instanceof Assets)
		{
			$this->_assets = $assets;
		}
		// Else if the assets config path has been set then create a new assets instance
		elseif ($this->_assets_config !== NULL)
		{
			$this->_assets = new Assets(Kohana::$config->load($this->_assets_config));

			if ($this->_assets_group !== NULL)
			{
				$this->_assets->group($this->_assets_group);
			}
		}
	}

	public static function factory($file = NULL, array $data = NULL)
	{
		$class = 'View_Model_' . strtr($file, '/', '_');

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
