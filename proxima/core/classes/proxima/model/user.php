<?php defined('SYSPATH') or die('No direct script access.');

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

	private function check_passwords($data)
	{
		// Check the passwords match.
		$validation = Validation::factory($data)
			->rules('password_confirm',
				array(
					array('matches',
						array(':validation', ':field', 'password')
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
			$data['username'],
			$data['password'],
			$data['remember']
		))
		{
			$validation = Validation::factory($data)
				->rules('username', array(
					array('not_empty'),
				))
				->rules('password', array(
					array('not_empty'),
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

	public function reset_password($data)
	{
		$rules = $this->rules();

		$data = Validation::factory($data)
			->rule('email','not_empty')
			->rule('email','email');

		if (!$data->check())
		{
			return FALSE;
		}

		$this->where('email', '=', $data['email']);
		$this->find();

		if (!$this->loaded())
		{
			return FALSE;
		}

		// generate the token
		$token = Auth::instance()->hash_password($this->email.'+'.$this->password);

		// generate the reset password link
		$url = URL::site('admin/auth/confirm_reset_password?id=' . $this->id . '&auth_token=' . $token, TRUE);

		// set the token in cookie
		Cookie::set('token', $token);

		$body = View::factory('admin/page/auth/email/reset_password')
			->set('user', $this)
			->set('url', $url);

		$swift_loader = Kohana::find_file('vendor', 'swiftmailer/lib/swift_required');

		if ($swift_loader === FALSE)
		{
			throw new Kohana_Exception('Swiftmailer library not found.');
		}

		require_once $swift_loader;

		$message = Swift_Message::newInstance()
			->setSubject('Password reset')
			->setFrom(array('your_website@domain'))
			->setTo(array($this->email => $this->username))
			->addPart($body, 'text/plain');

		$transport = Swift_MailTransport::newInstance();

		Swift_Mailer::newInstance($transport)->send($message);

		return TRUE;
	}

	public function confirm_reset_password(& $data, $token)
	{
		$cookie_token = Cookie::get('token', FALSE);

		if ( $token !== $cookie_token )
		{
			throw new Exception(__('Invalid auth token.'));
		}

		$rules = array_merge(
			$this->rules(),
			array('password_confirm' =>
				array(
					array('matches',
						array(':validation', ':field', 'password')
					)
				)
			)
		);

		$data = Validation::factory($data)
			->rules('password', $rules['password'])
			->rules('password_confirm', $rules['password_confirm']);

		$hash = $this->email.'+'.$this->password;

		if ( !$data->check() OR !$this->loaded() OR $token !== Auth::instance()->hash_password($hash))
		{
			return FALSE;
		}

		/* Remove token from cookie */
		Cookie::delete('token');

		/* Change users password. The password will be auto-hashed on save.*/
		$this->password = $data['password'];

		$this->save();

		return TRUE;
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
