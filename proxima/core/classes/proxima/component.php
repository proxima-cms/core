<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Component {

	// Component types
	const VIEW = 'view';
	const VIEW_MODEL = 'view_model';
	const REQUEST = 'request';

	// Component properties
	protected $_name;
	protected $_page;
	protected $_type;
	protected $_request;
	protected $_view;
	protected $_view_model;

	public static function factory(Page $page, $name, $type, $data = array())
	{
		return new Component($page, $name, $type, $data);
	}

	public function __construct(Page $page, $name, $type, Array $data = array())
	{
		$this->_name = $name;
		$this->_page = $page;
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
			$view = 'components/'.$controller.'/'.$action.'/'.$action;

			$this->_view_model = View_Model::factory($view, $data);
		}
	}

	public function name()
	{
		return $this->_name;
	}

	public function page()
	{
		return $this->_page;
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
		$cache_key = 'Component_'.$this->_name;

		if (!$html = Cache::instance()->get($cache_key))
		{
			try
			{
				if ($this->_type === Component::REQUEST)
				{
					$html = $this->_request->execute()->body();
				}
				elseif ($this->_type === Component::VIEW)
				{
					$html = $this->_view->render();
				}
				elseif ($this->_type === Component::VIEW_MODEL)
				{
					$html = $this->_view_model->render();
				}
				else
				{
					$html = __('Invalid component type');
				}

				Cache::instance()->set($cache_key, $html);
			}
			catch(Exception $e)
			{
				return Kohana_Exception::handler($e);
			}
		}

		return $html;
	}
}
