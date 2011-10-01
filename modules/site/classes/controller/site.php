<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site extends Controller_Base {

	public $theme = 'themes/default/';

	public $theme_url = 'modules/site/views/themes/default/';

	public function before()
	{
		$this->template = $this->theme.'page';

		parent::before();
	}

	public function action_index()
	{
		$uri = Arr::get($this->request->param(), 'url', '');

		$page = ORM::factory('site_page')->where('uri', '=', $uri)->find();

		if (!$page->loaded())
		{
			throw new HTTP_Exception_404('Page not found.');
		}

		$this->template->set_global('title', $page->title);
		$this->template->set_global('page', $page);
		$this->template->set_global('body', $page->body);
		$this->template->set_global('theme', $this->theme);
		$this->template->set_global('theme_url', $this->theme_url);

		$template = $this->theme.'templates/'.str_replace(EXT, '', $page->pagetype_template);

		$this->template->content = View::factory($template);
	}
	
	
} // End Controller_Site
