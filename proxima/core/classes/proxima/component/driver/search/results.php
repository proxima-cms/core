<?php defined('SYSPATH') or die('No direct access allowed.');

class Proxima_Component_Driver_Search_Results extends Component_Component {

	public $_default_config = array(
		'amount' => 5,
		'query'  => NULL,
	);

	public function render()
	{
		$amount = $this->config('amount');
		$query = $this->config('query');

		// TODO: cache results ?
		$cache_key = 'search-results' . (string) $amount . (string) $query;

		// Perform a fulltext search.
		$pages = ORM::factory('page')
			->search($query)
			->limit($this->_config['amount'])
			->find_all();

		return View::factory('components/search/results')
			->set('query', $query)
			->set('pages', $pages)
			->set('amount', $amount)
			->render();
	}
}
