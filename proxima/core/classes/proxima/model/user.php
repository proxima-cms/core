<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User model
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Model_User extends Model_Auth_User {

	protected $_has_many = array(
		'user_tokens'	=> array('model' => 'user_token'),
		'assets'			=> array('model' => 'asset'),
		'pages'				=> array('model' => 'pages'),
		'roles'				=> array('model' => 'role', 'through' => 'roles_users'),
		'groups'			=> array('model' => 'group', 'through' => 'groups_users')
	);

	public function admin_add($data = array())
	{
		$this->create_user($data, array('username', 'email', 'password', 'lang'));

		$roles  = Arr::get($data, 'roles');
		$groups = Arr::get($data, 'groups');

		if ($roles !== NULL)
		{
			$this->update_roles( (array) $roles);
		}
		if ($groups !== NULL)
		{
			$this->update_groups( (array) $groups);
		}
	}

	public function admin_update($data = array())
	{
		$this->check_passwords($data);
		$this->values($data);
		$this->save();

		$roles  = Arr::get($data, 'roles');
		$groups = Arr::get($data, 'groups');

		if ($roles !== NULL)
		{
			$this->update_roles( (array) $roles);
		}
		if ($groups !== NULL)
		{
			$this->update_groups( (array) $groups);
		}
	}

	// NOTE: not used since we started using $user->create_user();
	private function check_passwords($data)
	{
		// Check the passwords match.
		$validation = Validation::factory($data)
			->rules('password_confirm',
				array(
					array('matches',
						array(':validation', 'password', ':field')
					)
				)
			);

		if (!$validation->check())
		{
			throw new ORM_Validation_Exception('Passwords do not match', $validation);
		}
	}

	public function login($data)
	{
		if (!Auth::instance()->login(
			Arr::get($data, 'username'),
			Arr::get($data, 'password'),
			Arr::get($data, 'remember')
		))
		{
			$validation = Validation::factory($data)
				->rules('username', array(
					array('not_empty'),
				))
				->rules('password', array(
					array('not_empty'),
					// Check if username and password exist in DB
					array(function($validation, $field, $password, $username){

						$user = ORM::factory('user', array(
								'username' => 'username',
								'password' => 'password'
							));

						if ( ! $user->loaded())
						{
							$validation->error($field, 'incorrect_password');

							return FALSE;
						}

					}, array(':validation', ':field', ':value', ':username' => Arr::get($data, 'username')))
				));

			if ( ! $validation->check())
			{
				throw new Validation_Exception($validation);
			}
		}
		else
		{
			$this->where('id', '=', Auth::instance()->get_user()->id)->find();
		}
	}

	public function signup($data)
	{
		// Add a password confirmation check
		$validation = Validation::factory($data)
			->rules('password', array(
				array('not_empty')
			))
			->rules('password_confirm', array(
				array('matches', array(':validation', ':field', 'password')),
			));

		$this->values($data);
		$this->save($validation);
		$this->add('roles', new Model_Role(array('name' =>'login')));

		$message_body = View::factory('admin/page/auth/email/signup')
			->set('user', $this);

		$swift_loader = Kohana::find_file('vendor', 'swiftmailer/lib/swift_required');

		if ($swift_loader === FALSE)
		{
			throw new Exception('Swiftmailer library not found.');
		}

		require_once $swift_loader;

		$message = Swift_Message::newInstance()
			->setSubject('New account created')
			->setFrom(array('your_website@domain'))
			->setTo(array($this->email => $this->username))
			->addPart($message_body, 'text/plain');

		$transport = Swift_MailTransport::newInstance();

		Swift_Mailer::newInstance($transport)->send($message);
	}

	public function update_roles($roles)
	{
		foreach(ORM::factory('role')->find_all() as $role)
		{
			if (in_array($role->id, $roles))
			{
				try
				{
					// Add roles relationship
					$this->add('roles', new Model_Role(array('id' => $role->id)));
				}
				catch(Exception $e){}
			}
			else
			{
				// Remove roles relationship
				$this->remove('roles', new Model_Role(array('id' => $role->id)));
			}
		}
	}

	public function update_groups($groups)
	{
		foreach(ORM::factory('group')->find_all() as $group)
		{
			if (in_array($group->id, $groups))
			{
				try
				{
					// Add groups relationship
					$this->add('groups', new Model_Group(array('id' => $group->id)));
				}
				catch(Exception $e){}
			}
			else
			{
				// Remove groups relationship
				$this->remove('groups', new Model_Group(array('id' => $group->id)));
			}
		}
	}

	// Reset password validation check
	public static function exists_by_email($email, Model_User $user)
	{
		return $user->loaded();
	}

	public function reset_password($data)
	{
		// Try load the user
		$this->where('email', '=', Arr::get($data, 'email'))->find();

		// Check the email address
		$validation= Validation::factory($data)
			->bind(':model', $this)
			->rules('email', array(
				array('not_empty'),
				array('email'),
				array(array($this, 'exists_by_email'), array(':value', ':model'))
			));

		if (!$validation->check())
		{
			// Add the email back in, useful for displaying in form
			$this->values($data);

			throw new Validation_Exception($validation);
		}

		// Generate the token
		$token = Auth::instance()->hash_password($this->email.'+'.$this->password);

		// Generate the reset password link
		$url = URL::site(
			Route::get('admin')
				->uri(array(
					'controller' => 'auth',
					'action'     => 'confirm_reset_password'
				))
				. '?id=' . $this->id . '&auth_token=' . $token, TRUE);

		// Set the token in cookie
		Cookie::set('token', $token);

		// Get the email message view
		$email_html = View::factory('admin/page/auth/email/reset_password')
			->set('user', $this)
			->set('url', $url);

		// Send the reset password link email
		$email = Email::factory('Password reset', $email_html, 'text/html')
			->to($this->email, $this->username)
			->from(Kohana::$config->load('core.email_address'), Kohana::$config->load('core.email_name'))
			->send();

		return TRUE;
	}

	public function confirm_reset_password($data)
	{
		// Add a password confirmation check
		$validation = Validation::factory($data)
			->rules('password', array(
				array('not_empty')
			))
			->rules('password_confirm', array(
				array('matches', array(':validation', ':field', 'password')),
			));

		if ( !$validation->check())
		{
			throw new Validation_Exception($validation);
		}

		/* Change users password. The password will be auto-hashed on save.*/
		$this->password = $data['password'];
		$this->save();
	}

	public function friendly_date()
	{
		return Date::friendly($this->date);
	}

	public function __get($key)
	{
		if ($key === 'friendly_date')
		{
			return $this->friendly_date();
		}

		return parent::__get($key);
	}

} // End Model_User
