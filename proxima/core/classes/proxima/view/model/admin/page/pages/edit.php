<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Pages_Edit extends Proxima_View_Model_Admin_Page_Pages_Add {

	public function var_page_tags()
	{
		$page_tags = array();

		foreach($this->page->tags->find_all() as $tag)
		{
			$page_tags[] = $tag->id;
		}

		return $page_tags;
	}

	public function var_page_published()
	{
		return ORM::factory('site_page', $this->page->id)->loaded();
	}

}
