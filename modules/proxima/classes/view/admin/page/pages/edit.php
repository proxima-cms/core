<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Pages_Edit extends View_Model_Admin {

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);

		Page_View::instance()
			->styles(array(Kohana::$config->load('admin/media.paths.tinymce_skin')))
			->scripts(array(
				Kohana::$config->load('admin/media.paths.tinymce_jquery'),
				kohana::$config->load('admin/media.paths.tinymce_config'),
				Core::path('media/js/admin/pages/pages.js')
			));
	}

	public function var_pages()
	{
		return ORM::factory('page')
			->tree_select(4, 0, array(__('None')), 0, 'title');
	}

	public function var_tags()
	{
		return ORM::factory('tag')->order_by('name', 'asc')->find_all();
	}

	public function var_page_tags()
	{
		$page_tags = array();

		foreach($this->view->page->tags->find_all() as $tag)
		{   
			$page_tags[] = $tag->id;
		}

		return $page_tags;
	}

	public function var_page_types()
	{
		$page_types = array('' => 'None');

		foreach(ORM::factory('page_type')->find_all() as $page_type)
		{   
			$page_types[$page_type->id] = $page_type->name;
		} 

		return $page_types;
	}

	public function var_statuses()
	{
		return array(
			'' => __('Live'),
			'1' => __('Draft')
		);  
	}

	public function var_page_published()
	{
		return ORM::factory('site_page', $this->view->page->id)->loaded();
	}

}
