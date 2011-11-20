<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tag extends Controller_Page {

	public function action_index()
	{
    $tag_slug = Request::current()->param('param');
  
    if ($tag_slug === NULL)
    {   
      $tag_slug = Request::current()->query('name');
    }  

		$pages = Component::factory('Tag_Listing', array(
			'tag_slug'	=> $tag_slug
		))->render();

		$this->template->set_global('pages', $pages);
	}

	
} // End Controller_Search
