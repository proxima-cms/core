<?php defined('SYSPATH') or die('No direct script access.');

class View_Admin_Page_Assets_Edit extends View_Model {

	public function render($file = NULL)
	{
		$this->asset   = ORM::factory('asset', $this->id);
		$this->resized = $this->asset->sizes->where('resized', '=', 1)->find_all();
		$assets_index  = new View_Admin_Page_Assets_Index;
		$this->links   = $assets_index->get_filter_links();

		return parent::render($file);	
	}
}
