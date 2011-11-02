<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page extends Controller_Base {

	protected $page;

	public function before()
	{
		// Ensure this request is always executed as a sub-request.
		if (Request::current() === Request::initial())
		{
			throw new HTTP_Exception_404('Page not found');
		}
	
		// Set the master template.
		$this->template = Theme::path('page');

		// Set the controller template (along with other controller based stuff).
		parent::before();

		// Find the page.
		$this->page = Page::factory($this->request->param('uri'));
	
		// Set the page template.
		$template = Theme::path('templates/'.str_replace(EXT, '', $this->page->pagetype_template));
		$this->template->content = View::factory($template);

		// Set some generic page vars.
		$this->template->set('title', Kohana::$config->load('site.title') . ' - ' . $this->page->title);
		$this->template->set_global('page', $this->page);
	}

} // End Controller_Page
