<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Search extends Controller_Page {

	public function action_index()
	{
		$query = Request::current()->param('query');
	
		if ($query === NULL)
		{		
			$query = Request::current()->query('query');
		}

		// Ensure a query value has been supplied.
		if ($query === NULL)
		{
			throw new HTTP_Exception_404('Page not found');
		}

		// Search component configuration.
		$search_config = array(
			'query'		=> HTML::chars($query),
			'amount'	=> 10,
		);

		// Perform the search and get the results HTML.
		$search_results = Component::factory('Search_Results', $search_config)->render();

		// Pass the search results into the template.
		$this->template->set_global('search_results', $search_results);
	}

	
} // End Controller_Search