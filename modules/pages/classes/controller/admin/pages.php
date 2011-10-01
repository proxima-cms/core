<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template->title = __('Pages');
		$this->template->content = View::factory('admin/page/pages/index');
	}

	public function action_add()
	{
		$this->template->title = __('Add page');

		array_push($this->template->styles, Kohana::$config->load('admin/media.paths.tinymce_skin'));
		array_push($this->template->scripts, Kohana::$config->load('admin/media.paths.tinymce'));
		array_push($this->template->scripts, Kohana::$config->load('admin/media.paths.tinymce_init'));
		
		$this->template->content = View::factory('admin/page/pages/add')
			->bind('pages', $pages)
			->bind('tags', $tags)
			->bind('pagetypes', $pagetypes)
			->bind('errors', $errors);

		$pages = ORM::factory('page')->tree_select(4, 0, array(__('None')), 0, 'title');

		$tags = ORM::factory('tag')->find_all();

		$pagetypes = array('' => 'None');

		foreach(ORM::factory('pagetype')->find_all() as $pagetype)
		{
			$pagetypes[$pagetype->id] = $pagetype->name;
		}

		if ($_POST)
		{
			if (ORM::factory('page')->admin_add($_POST))
			{
				Message::set(Message::SUCCESS, __('Page saved.'));
				Request::current()->redirect('admin/pages');
			} 
			else if ($errors = $_POST->errors('admin/pages'))
			{
				 Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		
			$_POST = $_POST->as_array();
		}
	}
	
	public function action_edit()
	{
		$this->template->title = __('Edit page');

		array_push($this->template->styles, Kohana::$config->load('admin/media.paths.tinymce_skin'));
		array_push($this->template->scripts, Kohana::$config->load('admin/media.paths.tinymce'));
		array_push($this->template->scripts, Kohana::$config->load('admin/media.paths.tinymce_init'));

		$id = Request::current()->param('id');

		$page = ORM::factory('page', (int) $id);

		if (!$page->loaded())
		{
			throw new Kohana_Request_Exception('Page not found.');
		}

		$this->template->content = View::factory('admin/page/pages/edit')
			->bind('page', $page)
			->bind('pages', $pages)
			->bind('pagetypes', $pagetypes)
			->bind('tags', $tags)
			->bind('statuses', $statuses)
			->bind('page_tags', $page_tags)
			->bind('errors', $errors);

		$pages = ORM::factory('page')->tree_select(4, 0, array(__('None')), 0, 'title');
			
		$tags = ORM::factory('tag')->find_all();

		$page_tags = array();
		foreach($page->tags->find_all() as $tag)
		{
			$page_tags[] = $tag->id;
		}
		
		$pagetypes = array('' => 'None');
		foreach(ORM::factory('pagetype')->find_all() as $pagetype)
		{
			$pagetypes[$pagetype->id] = $pagetype->name;
		}

		$statuses = array(
			'' => __('Published'),
			'1' => __('Draft')
		);

		if ($_POST)
		{
			if ($page->admin_update($_POST))
			{
				Message::set(Message::SUCCESS, __('Page successfully updated.'));
			
				Request::current()->redirect('admin/pages/edit/'.$id);
			}
			else if ($errors = $_POST->errors('admin/pages'))
			{
 				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
		else
		{
			// Add the default data to POST
			$_POST = array_merge($_POST, $page->as_array());
		}
	}
	
	public function action_tree()
	{
		$open_pages = Arr::get($_COOKIE, 'pages/index', array());
		
		if ($open_pages)
		{
			$open_pages = explode(',', $open_pages);
		}

		$this->template->content = ORM::factory('page')->tree_list_html('admin/page/pages/tree', 0, $open_pages);
	}

} // End Controller_Admin_Pages
