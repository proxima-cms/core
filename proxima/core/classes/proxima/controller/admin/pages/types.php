<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Pages_Types extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template
			->title(__('Page types'))
			->content(
				View_Model::factory('admin/page/pages/types/index')
			);
	}

	public function action_add()
	{
		$this->template
			->title(__('Add page type'))
			->content(
				View_Model::factory('admin/page/pages/types/add')
					->bind('errors', $errors)
					->bind('page_type', $page_type)
			);

		$page_type = ORM::factory('page_type');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$page_type->admin_add($this->request->post());

				Message::set(Message::SUCCESS, __('Page type successfully saved.'));

				$this->request->redirect('admin/pages/types');
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/pages/types');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_edit()
	{
		$id = $this->request->param('id');

		$page_type = ORM::factory('page_type', $id);

		if (!$page_type->loaded())
		{
			throw new Kohana_Exception('Page type not found.');
		}

		$this->template
			->title(__('Edit page type'))
			->content(
				View_model::factory('admin/page/pages/types/edit')
					->set('page_type', $page_type)
					->bind('component', $component)
					->bind('errors', $errors)
			);

		$component = ORM::factory('component');

		if ($this->request->method() === Request::POST)
		{
			// Try save a new component to this page type
			if (Arr::get($this->request->post(), 'save-component') !== NULL)
			{
				$component->values(array(
					'user_id' => Auth::instance()->get_user()->id,
					'type_id' => (int) $this->request->post('component_type'),
					'page_type_id' => (int) $page_type->id,
					'data' => json_encode(array()),
					'name' => $this->request->post('component_name')
				));

				try
				{
					$component->save();

					Message::set(Message::SUCCESS, __('Component successfully saved.'));

					$this->request->redirect($this->request->uri());
				}
				catch(ORM_Validation_Exception $e)
				{
					$errors = $e->errors('admin/pages/component/types');

					foreach($errors as $key => $error)
					{
						$errors['component_'.$key] = $error;
						unset($errors[$key]);
					}

					die(print_r($errors));

					Message::set(Message::ERROR, __('Please correct the errors.'));
				}
			}
			// Try update the page type
			else
			{
				try
				{
					$page_type->admin_update($this->request->post());

					Message::set(Message::SUCCESS, __('Page type successfully updated.'));

					$this->request->redirect($this->request->uri());
				}
				catch(ORM_Validation_Exception $e)
				{
					$errors = $e->errors('admin/pages/types');

					Message::set(Message::ERROR, __('Please correct the errors.'));
				}
			}
		}
	}

	public function action_delete()
	{
		$page_type = ORM::factory('page_type', $this->request->param('id'));

		if (!$page_type->loaded())
		{
			throw new Request_Exception('Page type not found');
		}

		$page_type->delete();

		Message::set(Message::SUCCESS, __('Page type successully deleted.'));

		$this->request->redirect(
			Route::get('admin')
				->uri(array(
					'controller' => str_replace('_', '/', $this->request->controller())
				)));
	}

}
