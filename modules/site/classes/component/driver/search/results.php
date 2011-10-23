<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Search_Results extends Component_Component {

	public $_default_config = array(
		'amount' => 5,
	);	

	public function render()
	{

    $query = Request::current()->param('query');
  
    if ($query === NULL)
    {   
      $query = Request::current()->query('query');
    }

		$query = HTML::chars($query);

		// Perform a fulltext search.
		$pages = ORM::factory('page')
			->where(
				DB::expr('MATCH(page.title, page.description, page.body)'), 
				'', 
				DB::expr('AGAINST(' . Database::instance()->escape($query) . ')')
			)
			->limit($this->_config['amount'])
			->find_all();

		return View::factory(Theme::path('components/search/results'))
			->set('query', $query)
			->set('pages', $pages)
			->set('amount', $this->_config['amount'])
			->render();
	}
}