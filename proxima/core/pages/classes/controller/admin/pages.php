<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template->title = __('Pages');
		$this->template->content = View::factory('admin/page/pages/index');
		
		array_push($this->template->scripts, 
			'modules/pages/media/js/admin/pages.js'
		);
	}

	public function action_add()
	{
		$this->template->title = __('Add page');

		array_push($this->template->styles, Kohana::$config->load('admin/media.paths.tinymce_skin'));

		array_push($this->template->scripts, 
			Kohana::$config->load('admin/media.paths.tinymce_jquery'),
			kohana::$config->load('admin/media.paths.tinymce_config'),
			'modules/pages/media/js/admin/pages.js'
		);
		
		$this->template->content = View::factory('admin/page/pages/add')
			->set('pages', ORM::factory('page')->tree_select(4, 0, array(__('None')), 0, 'title'))
			->set('set', ORM::factory('tag')->find_all())
			->bind('page_types', $page_types)
			->bind('errors', $errors);

		$page_types = array('' => 'None');

		foreach(ORM::factory('page_type')->find_all() as $page_type)
		{
			$page_types[$page_type->id] = $page_type->name;
		}

		if ($this->request->method() === 'POST')
		{
			try
			{
				$page = ORM::factory('page')->admin_add($_POST);

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
		$this->template->title = __('Edit page');

		array_push($this->template->styles, Kohana::$config->load('admin/media.paths.tinymce_skin'));

		array_push($this->template->scripts, 
			Kohana::$config->load('admin/media.paths.tinymce_jquery'),
			kohana::$config->load('admin/media.paths.tinymce_config'),
			'modules/pages/media/js/admin/pages.js'
		);

		$id = Request::current()->param('id');

		$page = ORM::factory('page', (int) $id);

		if (!$page->loaded())
		{
			throw new Kohana_Request_Exception('Page not found.');
		}

		$this->template->content = View::factory('admin/page/pages/edit')
			->bind('page', $page)
			->bind('page_published', $page_published)
			->bind('pages', $pages)
			->bind('page_types', $page_types)
			->bind('tags', $tags)
			->bind('statuses', $statuses)
			->bind('page_tags', $page_tags)
			->bind('errors', $errors);

		$pages = ORM::factory('page')->tree_select(4, 0, array(__('None')), 0, 'title');
			
		$tags = ORM::factory('tag')->order_by('name', 'asc')->find_all();

		$page_tags = array();
		foreach($page->tags->find_all() as $tag)
		{
			$page_tags[] = $tag->id;
		}
		
		$page_types = array('' => 'None');
		foreach(ORM::factory('page_type')->find_all() as $page_type)
		{
			$page_types[$page_type->id] = $page_type->name;
		}

		$statuses = array(
			'' => __('Live'),
			'1' => __('Draft')
		);
	
		// Check if the page is published.
		$page_published = FALSE;
		$site_page = ORM::factory('site_page', $page->id);

		if ($site_page->loaded())
		{
			$page_published = TRUE;
		}

		if ($this->request->method() === 'POST')
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
	
	public function action_tree()
	{
		$open_pages = Arr::get($_COOKIE, 'pages/index', array());
		
		if ($open_pages)
		{
			$open_pages = explode(',', $open_pages);
		}

		$this->template->content = ORM::factory('page')->tree_list_html('admin/page/pages/tree', 0, $open_pages);
	}

	public function action_generate_uri()
	{
		$id = Arr::get($_GET, 'page_id');
		$title = Arr::get($_GET, 'title', NULL);

		$page = ORM::factory('page', $id);

		if (!$page->loaded())
		{
			throw new Kohana_Request_Exception('Page not found.');
		}

		if ($title !== NULL)
		{
			$page->title = $title;
		}

		$this->template->content = $page->generate_uri();
	}

} // End Controller_Admin_Pages
