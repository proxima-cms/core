<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Install extends Controller_Base {

	public $view_model = 'page/install/master/install';

	public function action_index()
	{
		$this->template
			->title(__('Install Proxima CMS'))
			->content(
				View::factory('page/install/index')
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

				// If it's an AJAX request, then return the errors as JSON
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

				// Try save the admin user
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

				// Send a welcome email to registered user
				$this->send_welcome_email($user);

				// Remove any cache generated by the installer
				Cache::instance()->delete_all();

				// If it's an AJAX request, then return the view as JSON
				if (Request::current()->is_ajax())
				{
					Request::current()->response()->headers('Content-Type', 'application/json');

					$this->template->content = json_encode(array('success' => $this->template->content->render()));
				}
			}
		}
	}

	private function send_welcome_email($user)
	{
		if (Kohana::$environment !== Kohana::DEVELOPMENT)
		{
			// Get the welcome email content
			$message_body = View::factory('page/install/email/signup')
				->set('user', $user);

			// Load swiftmailer
			$swift_loader = Kohana::find_file('vendor', 'swiftmailer/lib/swift_required');

			if ($swift_loader === FALSE)
			{
				throw new Exception('Swiftmailer library not found.');
			}

			require_once $swift_loader;

			// Build the email message
			$message = Swift_Message::newInstance()
				->setSubject('New account created')
				->setFrom(array('your_website@domain'))
				->setTo(array($user->email => $user->username))
				->addPart($message_body, 'text/plain');

			$transport = Swift_MailTransport::newInstance();

			// Send the welcome email
			Swift_Mailer::newInstance($transport)->send($message);
		}
	}

	// Remove the Proxima CMS tables
	public function action_uninstall()
	{
		// Remove any application cache
		Cache::instance()->delete_all();

		// Ensure the user is logged out to avoid any db session issues
		Auth::instance()->logout();

		// Run the uninstall migration task
		$migration_task = Minion_Task::factory('migrations_run')
			->execute(array('down' => TRUE));

		$this->request->redirect(Route::get('install')->uri());
	}

}
