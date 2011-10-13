<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site extends Controller_Base {

	public function before()
	{
		$this->template = Theme::path('page');
		//$config = Arr::merge(Kohana::$config->load(), require Kohana::find_file('views/themes/badsyntax/config/', 'media'));


		//die(print_r($config));
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
				throw new HTTP_Exception_404(__('Page not found.'));
			}

			Cache::instance()->set($cache_key, (object) $page->as_array());
		}		

		$this->template->set_global('title', $page->title);
		$this->template->set_global('page', $page);
		$this->template->set_global('body', $page->body);

		$template = Theme::path('templates/'.str_replace(EXT, '', $page->pagetype_template));

		$this->template->content = View::factory($template);
	}
	
} // End Controller_Site
