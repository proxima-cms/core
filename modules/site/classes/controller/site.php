<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site extends Controller_Base {

	public $theme = 'themes/default/';

	public function before()
	{
		$this->template = $this->theme.'master_page';

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

		$template = $this->theme.'templates/'.str_replace(EXT, '', $page->pagetype_template);

		$this->template->content = View::factory($template);
	}
	
	
} // End Controller_Site
