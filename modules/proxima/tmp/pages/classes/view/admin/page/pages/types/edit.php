<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Pages_Types_Edit extends View_Model {

	public function var_components()
	{
		return $this->view->page_type->component_type->find_all();
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
