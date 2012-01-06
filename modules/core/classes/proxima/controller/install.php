<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Install extends Controller_Base {

	public $view_model = 'admin/page/master/page/install';

	public function action_index()
	{
		$this->template
			->title(__('Install Proxima CMS'))
			->content(
				View::factory('admin/page/install/index')
				->bind('errors', $errors)
				->bind('user', $user)
				->bind('migration', $migration_task)
			);

		if ($this->request->method() === Request::POST)
		{
			$user_rules = array(
				'username' => array(
					array('not_empty'),
					array('max_length', array(':value', 32)),
				),
				'password' => array(
					array('not_empty'),
				),
				'password_confirm' => array(
					array('matches', array(':validation', ':field', 'password'))
				),
				'email' => array(
					array('not_empty'),
					array('email'),
				),
			);

			$validation = Validation::factory($this->request->post());

			foreach($user_rules as $field => $rules)
			{
				$validation->rules($field, $rules);
			}

			if (!$validation->check())
			{
				$user = $this->request->post();

				$errors = $validation->errors('install');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
			else
			{
				$migration_task = Minion_Task::factory('migrations_run')
					->execute(array());

				try
				{
					ORM::factory('user')->admin_add($this->request->post());
				}
				catch(ORM_Validation_Exception $e)
				{
					die(print_r($e->errors()));
				}
			}
		}
	}

	public function action_uninstall()
	{
		$migration_task = Minion_Task::factory('migrations_run')
			->execute(array('down' => TRUE));

		$this->request->redirect(Route::get('install')->uri());
	}

}
