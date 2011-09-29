<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tags extends Controller_Admin_Base {

	public function action_add()
	{
		$this->template->title = __('Add tag');

		$this->template->content = View::factory('admin/page/tags/add')
			->bind('errors', $errors);

		if ($_POST)
		{

			if (ORM::factory('tag')->admin_add($_POST))
			{		
				Message::set(Message::SUCCESS, __('Tag successfully saved.'));		 
			}	

			if ($errors = $_POST->errors('admin/tags'))
			{		
				 Message::set(Message::ERROR, __('Please correct the errors.'));
			}

			$_POST = $_POST->as_array();
		}
	}
	
	
} // End Controller_Admin_Tags
