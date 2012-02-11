<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Page {

	protected $data;

	public function __construct($uri = NULL)
	{
		$uri = (string) $uri;

		$cache_key = 'page-'.$uri;

		if (!$this->data = Cache::instance()->get($cache_key))
		{
			$this->data = ORM::factory('site_page')->where('uri', '=', $uri)->find();

			if (!$this->data->loaded())
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

			Cache::instance()->set($cache_key, (object) $this->data->as_array());
		}
	}

	public static function factory($uri = NULL)
	{
		return new Page($uri);
	}

	public function __get($property)
	{
		return $this->data->$property;
	}

}
