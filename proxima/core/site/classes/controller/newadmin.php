<?php defined('SYSPATH') or die('No direct script access.');

class Controller_NewAdmin extends Controller_Base {
			
	public $template = 'themes/newadmin/page';

	public function action_index()
	{
		$this->template->sidebar = Theme::view('fragments/sidebar', FALSE, 'newadmin');
		$this->template->content = Theme::view('templates/newadmin', FALSE, 'newadmin');
	}

	public function action_pages()
	{
		$this->template->sidebar = Theme::view('fragments/pages/sidebar', FALSE, 'newadmin');
		$this->template->content = Theme::view('templates/pages/index', FALSE, 'newadmin');
	}

}
