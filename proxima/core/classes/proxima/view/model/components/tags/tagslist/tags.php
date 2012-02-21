<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Components_Tags_Tagslist_Tags extends View_Model {

	public function var_tags()
	{
		return ORM::factory('tag')->find_all();
	}
}
