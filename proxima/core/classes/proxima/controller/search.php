<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Site search controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Search extends Controller_Page {

	public function action_index()
	{
		$query = $this->request->param('query');

		if ($query === NULL)
		{
			$query = $this->request->query('query');
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
		$this->template->content->set('search_results', $search_results);
	}

}
