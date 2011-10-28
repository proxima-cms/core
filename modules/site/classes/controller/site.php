<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site extends Controller_Base {

	public function before()
	{
		$this->template = Theme::path('page');

		parent::before();
	}

	public function action_index()
	{
		$uri = (string) $this->request->param('uri');

		$cache_key = 'page-'.$uri;

		if (!$page = Cache::instance()->get($cache_key))
		{		
			$page = ORM::factory('site_page')->where('uri', '=', $uri)->find();
		
			if (!$page->loaded())
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

			Cache::instance()->set($cache_key, (object) $page->as_array());
		}		

		$this->template->set('title', Kohana::$config->load('site.title') . ' - ' . $page->title);
		$this->template->set_global('page', $page);

		$template = Theme::path('templates/'.str_replace(EXT, '', $page->pagetype_template));

		$this->template->content = View::factory($template);
	}
	
} // End Controller_Site
