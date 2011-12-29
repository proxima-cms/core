<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Page extends Controller_Base {

	public $view_model = 'themes/badsyntax/page/master';

	public function before()
	{
		parent::before();

		$page = Page::factory($this->request->param('uri'));

		// Get the page template from the page type.
		$template = Theme::path('templates/' . str_replace(EXT, '', $page->pagetype_template));

		// Generate the page title.
		$page->title = Kohana::$config->load('site.title') . ' - ' . $page->title;

		Page_view::instance()
			->page($page)
			->content(
				View::factory($template)
				->set('page', $page)
			);
	}

	public function action_index()
	{
		// Nothing by default, but intentionally set to allow the route to match the default method.
	}

} // End Controller_Page
