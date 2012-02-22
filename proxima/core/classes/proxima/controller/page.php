<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Page extends Controller_Base {

	// Master template view model
	public $view_model = 'page/master';

	public function before()
	{
		parent::before();

		if ($this->request->is_initial())
		{
			// Create a new page instance
			$page = Page::factory($this->request->param('uri'));

			// Generate the page title.
			$page->title = Kohana::$config->load('site.title') . ' - ' . $page->title;

			// Get the page template from the page type.
			$template = 'templates/' . str_replace(EXT, '', $page->pagetype_template);

			$this->template->page = $page;

			$this->template->content = View::factory($template)->set('page', $page);
		}
		// Let's not find the page in the db if we're only returning the inner template
		else
		{
			$template = 'templates/page';

			$this->template->content = View::factory($template);
		}

	}

	public function action_index()
	{
		// Nothing by default, but intentionally set to allow the route to match the default method.
	}

} // End Controller_Page
