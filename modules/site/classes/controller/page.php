<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page extends Controller_Base {

	protected $page;

	public function before()
	{
		// Set the master template.
		$this->template = Theme::path('page');

		// Set the controller template (along with other controller based stuff).
		parent::before();

		// Get the page.
		$this->page = Page::factory($this->request->param('uri'));
	
		// Get the page template from the page type.
		$template = Theme::path('templates/'.str_replace(EXT, '', $this->page->pagetype_template));

		// Set the page template & content. (Content is set via page components in the template.)
		$this->template->content = View::factory($template);

		// Set some generic page vars.
		$this->template->set_global(array(
			'title' => Kohana::$config->load('site.title') . ' - ' . $this->page->title,
			'page'  => $this->page
		));
	}

	public function action_index()
	{
		// Nothing by default, but intentionally set to allow the route to match the default method.
	}

} // End Controller_Page
