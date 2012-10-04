<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Installer controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Install extends Controller_Base {

	public $view_model = 'install/page/master';

	public function before()
	{
		$can_install = Kohana::$config->load('install.can_install_uninstall');

		// Secure this controller
	 	if ($can_install !== NULL AND (bool) $can_install === FALSE)
	 	{
			$this->request->redirect();
	 	}

		// If it's an AJAX request, then set the response content type as JSON
		if (Request::current()->is_ajax())
		{
			Request::current()->response()->headers('Content-Type', 'application/json');
		}

		parent::before();
	}

	public function action_index()
	{
		$this->template
			->title(__('Install Proxima CMS'))
			->content(
				View::factory('install/page/index')
				->bind('errors', $errors)
				->bind('user', $user)
				->bind('migration', $install_migration)
			);


		if (!Proxima::$is_installed && $this->request->method() === Request::POST)
		{
			// We cant use the Model_User model to validate the user details as the db table doesn't exist
			$user_rules = array(
				'username' => array(
					array('not_empty'),
					array('max_length', array(':value', 32))
				),
				'password' => array(
					array('not_empty'),
					array('min_length', array(':value', 8))
				),
				'email' => array(
					array('not_empty'),
					array('email', array(':value')),
				),
				'password_confirm' => array(
					array('matches', array(':validation', 'password', ':field'))
				)
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
					$this->template->content = json_encode($errors);
				}
			}
			// Successfully validated the admin user details
			else
			{
				$migration_groups = array('install');

				if (Arr::get($this->request->post(), 'demo_pages') !== NULL)
				{
					$migration_groups[] = 'install_demopages';
				}

				// Run the install migration task
				$install_migration = Minion_Task::factory('migrations_run')
					->execute(array('groups' => $migration_groups));

				// Load the user
				$user = ORM::factory('user')
					->where('username', '=', Arr::get($this->request->post(), 'username'))
					->find();

				// Check if the user already exists
				if ($user->loaded())
				{
					$this->request->redirect(Route::get('install')->uri());
				}

				// Save the user to the db
				$user->admin_add($this->request->post());
				$user->add('roles', new Model_Role(array('name' => 'login')));
				$user->add('roles', new Model_Role(array('name' => 'admin')));

				// Get the welcome email content
				$email_body    = View::factory('install/page/email/signup')->set('user', $user);
				$email_subject = __('Proxima CMS successfully installed - New account created');

				// Send the welcome email
				$email = Email::factory($email_subject, $email_body)
					->to($user->email, $user->username)
					->from('your_website@domain', 'Root') // TODO: use config or details specified in the install form
					->send();

				// Remove any cache generated by the installer
				Cache::instance()->delete_all();

				// If it's an AJAX request, then return the view as JSON
				if (Request::current()->is_ajax())
				{
					$this->template->content = json_encode(array(
						'success' => $this->template->content->render()
					));
				}
			}
		}
	}

	// Remove the Proxima CMS tables
	public function action_uninstall()
	{
		// We cant uninstall if we're already installed
		if (!Proxima::$is_installed)
		{
			throw new Kohana_Exception('Proxima CMS is not installed');
		}

		// Get the applied migrations
		$migration = new Model_Minion_Migration(Database::instance());
		$applied_migrations = $migration->fetch_current_versions('group');

		// Uninstall migrations will not be run if no migrations have been applied
		if (!count($applied_migrations))
		{
			throw new Exception('No migrations have been applied');
		}

		// Remove any application cache
		Cache::instance()->delete_all();

		// Ensure the user is logged out to avoid any db session issues
		Auth::instance()->logout();

		// Run the uninstall migrations
		$migrations = Minion_Task::factory('migrations_run')
			->execute(array('down' => TRUE));

		// Check if any migrations were actually run
		if (!count($migrations->executed_migrations))
		{
			throw new Kohana_Exception('No migrations were run');
		}

		$this->request->redirect(
			Route::get('install')->uri()
		);
	}

	// Disable the installer
	public function action_disable()
	{
		$return_to = $this->request->query('return_to');

		$config = ORM::factory('config')
			->where('group_name', '=', 'install')
			->where('config_key', '=', 'can_install_uninstall')
			->find();

		$config->config_value = serialize('0');
		$config->group_name = 'install';
		$config->config_key = 'can_install_uninstall';
		$config->save();

		$this->request->redirect($return_to);
	}

	// Enable the installer
	public function action_enable()
	{

	}

	// Display environment tests
	public function action_tests()
	{
		$this->template
			->title(__('Environment Tests'))
			->content(
				View::factory('install/page/tests')
			);
	}

	// Display install 'success' message
	public function action_success()
	{
		$this->template
			->title(__('Install Success'))
			->content(
				View::factory('install/page/success')
			);
	}
}
