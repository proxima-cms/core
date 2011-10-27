<?php defined('SYSPATH') or die('No direct script access.');
/*
* User model
* some concepts and code taken from https://github.com/GeertDD/kohanajobs/blob/master/application/classes/model/user.php
*/

class Model_User extends Model_Auth_User {
	
	// Relationships (TODO: check these relationsips aren't already set in auth)
	protected $_has_many = array(
		'user_tokens'		=> array('model' => 'user_token'),
		'assets'				=> array('model' => 'asset'),
		'pages'					=> array('model' => 'pages'),
		'roles'					=> array('model' => 'role', 'through' => 'roles_users'),
		'groups'				=> array('model' => 'group', 'through' => 'groups_users')
	);

	public function admin_add($data = array())
	{
		$this->check_passwords($data);
		$this->values($data);
		$this->save();
		
		$this->update_roles((array) Arr::get($data, 'roles'));
		$this->update_groups((array) Arr::get($data, 'groups'));
	}

	public function admin_update($data = array())
	{
		$this->check_passwords($data);
		$this->values($data);
		$this->save();

		$this->update_roles((array) Arr::get($data, 'roles'));
		$this->update_groups((array) Arr::get($data, 'groups'));
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
				));

		if (!$validation->check())
		{
			throw new ORM_Validation_Exception('Passwords do not match', $validation);
		}
	}

	public function login(array & $data, $redirect = FALSE)
	{
		if (Auth::instance()->login(Arr::get($data, 'username'), Arr::get($data, 'password')))
		{
			return TRUE;
		}
		else
		{
			$data = Validation::factory($data)
				->rule('username','trim')
				->rule('username','not_empty')
				->rule('password','not_empty');

			if ($data->check())
			{
				$data->error('password','invalid');
			}
			
			return FALSE;
		}
	}

	public function signup(& $data)
	{
		$data = Validation::factory($data)
			->rules('password', $this->_rules['password'])
			->rules('username', $this->_rules['username'])
			->rules('email', $this->_rules['email'])
			->rules('password_confirm', $this->_rules['password_confirm']);
 
		// Add validate callbacks
		foreach($this->_callbacks['username'] as $callback)
		{
			$data->callback('username', array($this, $callback));
		} 
		foreach($this->_callbacks['email'] as $callback)
		{
			$data->callback('email', array($this, $callback));
		}		
 
		// Check the validation
		if (!$data->check()) return FALSE;

		$this->values($data);
		$this->save();
		$this->add('roles', new Model_Role(array('name' =>'login')));

		Auth::instance()->login($data['username'], $data['password']);

		return $data;
	}

	public function update_roles($roles)
	{
		foreach(ORM::factory('role')->find_all() as $role) {

			if (in_array($role->id, $roles)) {

				try {
					// Add roles relationship
					$this->add('roles', new Model_Role(array('id' => $role->id)));

				} catch(Exception $e){}

			} else {
				// Remove roles relationship
				$this->remove('roles', new Model_Role(array('id' => $role->id)));
			}
		}
	}
	
	public function update_groups($groups)
	{
		foreach(ORM::factory('group')->find_all() as $group) {

			if (in_array($group->id, $groups)) {

				try {
					// Add roles relationship
					$this->add('groups', new Model_Group(array('id' => $group->id)));

				} catch(Exception $e){}

			} else {
				// Remove roles relationship
				$this->remove('groups', new Model_Group(array('id' => $group->id)));
			}
		}
	}

	public function reset_password(& $data)
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

} // End Model_User
