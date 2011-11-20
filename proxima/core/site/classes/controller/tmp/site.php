<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Site extends Controller {

	public function action_index()
	{
		$page = Page::factory($this->request->param('uri'));

		// Get the page route.
		// $uri = $page->route . '/' . $page->uri;
		//$uri = 'proxima-search' . '/' . $page->uri;
		//$uri = '';
		//$uri = '';
		$uri = 'proxima-page/'.$page->uri;

		$request = Request::factory($uri)
			->query($this->request->query())
			->post($this->request->post());

		$this->request->response($request->execute());
	}
	
} // End Controller_Site
