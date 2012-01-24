<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Pages_Types_Edit extends Proxima_View_Model_Admin_Page_Pages_Types_Add {

	public function var_components()
	{
		return $this->page_type->component_type->find_all();
	}

	public function var_component_types()
	{
		$types = array();

		foreach(ORM::factory('component_type')->find_all() as $type)
		{
			$types[$type->id] = $type->name;
		}

		return $types;
	}

}
