<?php

class Core {

	public static function set_routes()
	{
		// Find all pages that require routing to specific controllers.
		$route_pages = ORM::factory('site_page')
				->where('pagetype_controller', '<>', 'page')
				->and_where('pagetype_controller', 'IS NOT', NULL)
				->find_all();

		foreach($route_pages as $page)
		{
			// Set the page route.
			Route::set($page->uri, $page->uri.'(/<param>)', array('param' => '.*'))
				->defaults(array(
					'controller' => $page->pagetype_controller,
					'action'     => 'index',
					'uri'        => $page->uri,
				));
		}

		// Set the 'catch all' route.
		Route::set('page', '<uri>', array('uri' => '.*'))
			->defaults(array(
				'controller' => 'page',
				'action'     => 'index'
			));
	}
}
