<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller_Admin_Base {

	public function action_index()
	{
		Page_View::instance()
		->title(__('Pages'))
		->content(
			View_Model::factory('admin/page/pages/index')
		);
	}

	public function action_add()
	{
		Page_View::instance()
		->title(__('Add page'))
		->content(
			View_Model::factory('admin/page/pages/add')
				->bind('errors', $errors)
		);
		
		if ($this->request->method() === Request::POST)
		{
			try
			{
				$page = ORM::factory('page')->admin_create($this->request->post());

				Message::set(Message::SUCCESS, __('Page successfully saved.'));
				
				Request::current()->redirect('admin/pages/edit/'.$page->id);
			} 
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/pages');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}
	
	public function action_edit()
	{
		Page_View::instance()
		->title(__('Edit page'))
		->content(
			View_Model::factory('admin/page/pages/edit')
				->bind('page', $page)
				->bind('errors', $errors)
		);

		$page = ORM::factory('page', $this->request->param('id'));

		if (!$page->loaded())
		{
			throw new Request_Exception('Page not found.');
		}

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$page->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __('Page successfully updated.'));
			
				Request::current()->redirect('admin/pages/edit/'.$id);
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/pages');

 				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_delete()
	{
		$page = ORM::factory('page', $this->request->param('id'));

		if (!$page->loaded())
		{
			throw new Exception('Page not found');
		}

		$page->delete();

		Message::set(Message::SUCCESS, __('Page successully deleted.'));

		$this->request->redirect('admin/pages');
	}
	
	public function action_tree()
	{
		$open_pages = explode(',', Arr::get($_COOKIE, 'pages/index'));
		
		Page_View::instance()
			->content(
				ORM::factory('page')->tree_list_html('admin/page/pages/tree', 0, $open_pages)
			);
	}

	public function action_generate_uri()
	{
		$page_id = $this->request->query('page_id');
		$title   = $this->request->query('title');

		$page = ORM::factory('page', $page_id);

		if (!$page->loaded())
		{
			throw new Request_Exception('Page not found.');
		}

		if ($title !== NULL)
		{
			$page->title = $title;
		}

		Page_View::instance()
			->title(__('Page URI generation'))
			->content(
				$page->generate_uri()
			);
	}

} // End Controller_Admin_Pages
