<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin pages controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Pages extends Controller_Admin_Base {

	public function action_index()
	{
		$open_pages = explode(',', Arr::get($_COOKIE, 'pages/index'));

		$this->template
			->title(__('Pages'))
			->content(
				View_Model::factory('admin/page/pages/index')
				->set('pages_tree', ORM::factory('page')->tree_list_html('admin/page/pages/tree', 0, $open_pages))
			);
	}

	public function action_add()
	{
		$this->template
			->title(__('Add page'))
			->content(
				View_Model::factory('admin/page/pages/add', array('template' => $this->template))
					->bind('errors', $errors)
					->bind('page', $page)
			);

		$page = ORM::factory('page');
		$page->parent_id = $this->request->param('id');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$page->admin_create($this->request->post());

				Message::set(Message::SUCCESS, __('Page successfully saved.'));

				$this->request->redirect('admin/pages/edit/'.$page->id);
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
		$this->template
			->title(__('Edit page'))
			->content(
				View_Model::factory('admin/page/pages/edit', array('template' => $this->template))
					->bind('page', $page)
					->bind('errors', $errors)
			);

		$page = ORM::factory('page', $this->request->param('id'));

		if (!$page->loaded())
		{
			throw new HTTP_Exception_404('Page not found.');
		}

		if ($this->request->method() === Request::POST)
		{
			try
			{
				// Add new tag
				if ($this->request->post('add-new-tag') !== NULL)
				{
					$page->admin_add_tag($this->request->post());

					Message::set(Message::SUCCESS, __('New tag successfully added.'));
				}
				// Update page
				else
				{
					$page->admin_update($this->request->post());

					Message::set(Message::SUCCESS, __('Page successfully updated.'));
				}

				$this->request->redirect(
					Route::get('admin')
						->uri(array(
							'controller' => 'pages',
							'action' => 'edit',
							'id' => $page->id
						)));
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

		// Check if this page can actually be deleted
		if (!$page->deletable)
		{
			Message::set(Message::ERROR, __('This page can not be deleted.'));

			$this->request->redirect($this->request->referrer());
		}

		$page->admin_delete();

		Message::set(Message::SUCCESS, __('Page successully deleted.'));

		$this->request->redirect(
			Route::get('admin')
			->uri(array(
				'controller' => 'pages',
			))
		);
	}

	public function action_tree()
	{
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

		$this->template
			->title(__('Page URI generation'))
			->content(
				$page->generate_uri()
			);
	}

}
