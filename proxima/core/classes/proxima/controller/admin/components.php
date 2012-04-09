<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin components controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Components extends Controller_Admin_Base {

	public function action_index()
	{
		$request_data = array('request' => $this->request->query());

		$this->template
			->title(__('Components'))
			->content(
				View_Model::factory('admin/page/component/types/index', $request_data)
			);
	}

	public function action_add()
	{
		$request_data = array('request' => $this->request->post());

		$this->template
			->title(__('Add component'))
			->content(
				View_Model::factory('admin/page/component/types/add', $request_data)
				->bind('errors', $errors)
				->bind('component', $component)
			);

		$component = ORM::factory('component_type');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$component->admin_add($this->request->post());

				Message::set(Message::SUCCESS, __('Component successfully saved.'));

				Request::current()->redirect('admin/components/edit/'.$component->id);
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/components');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_edit()
	{
		$request_data = array('request' => $this->request->post());

		$this->template
			->title(__('Edit page'))
			->content(
				View_Model::factory('admin/page/component/types/edit', $request_data)
				->bind('errors', $errors)
				->bind('component', $component)
			);

		$id = Request::current()->param('id');

		$component = ORM::factory('component_type', $id);

		if (!$component->loaded())
		{
			throw new Kohana_Request_Exception('Component not found.');
		}

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$component->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __('Component successfully updated.'));

				Request::current()->redirect('admin/components/edit/'.$id);
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/components');

 				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_delete()
	{
		$id = $this->request->param('id');

		$component = ORM::factory('component', $id);

		if (!$component->loaded())
		{
			throw new Exception('Component not found');
		}

		$component->delete();

		Message::set(Message::SUCCESS, __('Component successfully deleted.'));

		$this->request->redirect('admin/components');
	}

} // End Controller_Admin_Components
