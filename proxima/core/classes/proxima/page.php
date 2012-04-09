<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Site page helper class
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Page {

	protected $_data;

	protected $_components;

	public static function factory($uri = NULL)
	{
		return new Page($uri);
	}

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

			Request::current()->redirect($target->uri, 301);
		}

		return $data;
	}

	private function get_components()
	{
		if ($this->_components === NULL)
		{
			$components = array();

			// First we get the default page type components
			foreach($this->page_type->component->find_all() as $component)
			{
				$components[$component->name] = $component;
			}

			// Now we get the page specifc components, overwriting the page type components
			foreach($this->component->find_all() as $component)
			{
				$components[$component->name] = $component;
			}

			// Note:: we could probably combine the last two queries into one

			$this->_components = $components;
		}

		return $this->_components;
	}

	public function component($name, $data = array(), $type = Component::REQUEST)
	{
		$components = $this->get_components();

		if (isset($components[$name]))
		{
			$data = $components[$name]->data();
		}

		return Component::factory($this, $name, $type, $data);
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
