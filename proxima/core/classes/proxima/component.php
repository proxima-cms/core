<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Component {

	// Component types
	const VIEW = 'view';
	const VIEW_MODEL = 'view_model';
	const REQUEST = 'request';

	protected $_type;

	protected $_request;

	protected $_view;

	protected $_view_model;

	public static function factory($name = NULL, $data = array(), $type = NULL)
	{
		return new Component($name, $data, $type);
	}

	public function __construct($name = NULL, $data = array(), $type = NULL)
	{
		$this->_type = $type ?: Component::REQUEST;

		list($controller, $action) = array_map('strtolower', explode('_', $name, 2));

		if ($this->_type === Component::REQUEST)
		{
			$route= Route::get('component')
				->uri(array(
					'controller' => $controller,
					'action' => $action
				));

			$this->_request = Request::factory($route)->query($data);
		}
		elseif ($this->_type === Component::VIEW)
		{
			$view = 'components/'.$controller.'/'.$action.'/'.$action;

			$this->_view = View::factory($view, $data);
		}
		elseif ($this->_type === Component::VIEW_MODEL)
		{
			$this->_view_model = '';
		}
	}

	public function request()
	{
		return $this->_request;
	}

	public function view()
	{
			return $this->_view;
	}

	public function view_model()
	{
		return $this->_view_model();
	}

	public function __toString()
	{
		return $this->render();
	}

	public function render()
	{
		try
		{
			if ($this->_type === Component::REQUEST)
			{
				return $this->_request->execute()->body();
			}
			elseif ($this->_type === Component::VIEW)
			{
				return $this->_view->render();
			}
			elseif ($this->_type === Component::VIEW_MODEL)
			{
				return $this->_view_model->render();
			}
			else
			{
				return 'Invalid component type';
			}
		}
		catch(Exception $e)
		{
			return Kohana_Exception::handler($e);
		}
	}
}
