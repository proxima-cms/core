<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Wysiwyg extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template
			->title(__('Admin - Wysiwyg'))
			->content(
				View::factory('admin/page/wysiwyg/index')
				->bind('db_config', $db_config)
				->bind('modules', $modules)
			)
			->styles(array(
				Kohana::$config->load('admin/media.paths.tinymce_skin')
			));
	}

} // End Controller_Admin_Wysiwyg
