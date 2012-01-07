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

				if (Request::current()->is_ajax())
				{
					Request::current()->response()->headers('Content-Type', 'application/json');

					$this->template->content = json_encode($errors);
				}
			}
			else
			{
				// Run the migration task
				$migration_task = Minion_Task::factory('migrations_run')->execute(array());

				$user = ORM::factory('user');

				try
				{
					$user->admin_add($this->request->post());
					$user->add('roles', new Model_Role(array('name' => 'login')));
					$user->add('roles', new Model_Role(array('name' => 'admin')));
				}
				catch(ORM_Validation_Exception $e)
				{
					throw new Exception('Unabled to create new admin user');
				}

				Cache::instance()->delete_all();

				if (Request::current()->is_ajax())
				{
					Request::current()->response()->headers('Content-Type', 'application/json');

					$this->template->content = json_encode(array('success' => $this->template->content->render()));
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
