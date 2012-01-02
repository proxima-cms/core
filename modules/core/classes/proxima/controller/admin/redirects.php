<?php

class Proxima_Controller_Admin_Redirects extends Controller_Admin_Base {

	public function action_index()
	{
		$request_data = array('request' => $this->request->query());

		$this->template
			->title(__('Redirects'))
			->content(
				View_Model::factory('admin/page/redirects/index', $request_data)
			);
	}

	public function action_add()
	{
		$this->template
			->title(__('Add redirect'))
			->content(
				View_Model::factory('admin/page/redirects/add')
				->bind('redirect', $redirect)
				->bind('errors', $errors)
			);

		$redirect = ORM::factory('redirect');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$redirect->admin_add($this->request->post());

				Message::set(Message::SUCCESS, __('Redirect successfully saved.'));

				$this->request->redirect(
					Route::get('admin')
					->uri(array(
						'controller' => 'redirects'
					))
				);
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/redirects');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_edit()
	{
		$redirect = ORM::factory('redirect', $this->request->param('id'));

		if (!$redirect->loaded())
		{
			throw new Request_Exception('Redirect not found.');
		}

		$this->template
			->title(__('Edit redirect'))
			->content(
				View_Model::factory('admin/page/redirects/edit')
				->set('redirect', $redirect)
				->bind('errors', $errors)
			);

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$redirect->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __('Redirect successfully saved.'));

				$this->request->redirect($this->request->uri());
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/redirects');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

}
