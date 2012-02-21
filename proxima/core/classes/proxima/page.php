<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Page {

	protected $_data;

	protected $_components;

	public function __construct($uri = NULL)
	{
		$this->_data = $this->get_page($uri);
	}

	private function get_page($uri = NULL)
	{
		$data = ORM::factory('site_page')->where('uri', '=', $uri)->find();

		if (!$data->loaded())
		{
			// Check for a page redirect.
			$redirect = ORM::factory('redirect')->where('uri', '=', $uri)->find();

			if (!$redirect->loaded())
			{
				throw new HTTP_Exception_404('Page not found.');
			}

			$target = ORM::factory($redirect->target, $redirect->target_id);

			$this->request->redirect($target->uri, 301);
		}

		return $data;
	}

	public static function factory($uri = NULL)
	{
		return new Page($uri);
	}

	public function component($name)
	{
		die('component: '.$name);
	}

	public function __isset($key)
	{
		return isset($this->_data->{$key});
	}

	public function __unset($key)
	{
		unset($this->_data->{$key});
	}

	public function __get($key)
	{
		return $this->_data->{$key};
	}

}
