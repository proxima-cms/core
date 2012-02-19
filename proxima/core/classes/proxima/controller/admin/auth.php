<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Auth extends Controller_Admin_Base {

	public $view_model = 'admin/page/auth/master/page';

	public $_auth_required = FALSE;

	public function action_signin()
	{
		// Redirect if user is logged in
		if (Auth::instance()->logged_in())
		{
			$this->request->redirect($this->request->query('return_to') ?: Route::get('admin')->uri());
		}

		$this->template
			->title(__('Sign in'))
			->content(
				View_Model::factory('admin/page/auth/signin')
				->bind('errors', $errors)
				->bind('user', $user)
			);

		$user = ORM::factory('user');

		if ($this->request->method() == Request::POST)
		{
			try
			{
				$user->login($this->request->post());

				Message::set(Message::SUCCESS, __(':username successfully signed in.', array(':username' => $user->username)));

				$return = $this->request->post('return_to') ?: Route::get('admin')->uri();

				$this->request->redirect( $return );
			}
			catch(Validation_Exception $e)
			{
				$errors = $e->array->errors('signin');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_signup()
	{
		if (Auth::instance()->logged_in())
		{
			$this->request->redirect();
		}

		$this->template
			->title(__('Sign up'))
			->content(
				View_Model::factory('admin/page/auth/signup')
				->bind('errors', $errors)
				->bind('user', $user)
			);

		$user = ORM::factory('user');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$user->signup($this->request->post());

				Message::set(Message::SUCCESS, __(':username successully registered.', array('username' => $this->request->post('username'))));

				Auth::instance()->login($this->request->post('username'), $this->request->post('password'));

				$this->request->redirect();
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/auth/signup');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_profile()
	{
		if ( ! Auth::instance()->logged_in())
		{
			$this->request->redirect(
				Route::get('admin')
				->uri(array(
					'controller' => 'auth',
					'action' => 'signin'
				))
			);
		}

		$this->template
			->title(__('Profile'))
			->content(
				View_Model::factory('admin/page/auth/profile')
				->bind('errors', $errors)
				->bind('user', $user)
			);

		$user = Auth::instance()->get_user();

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$user->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __(':username profile updated.', array(':username' => $user->username)));

				$this->request->redirect(
					Route::get('admin')
					->uri(array(
						'controller' => 'auth',
						'action' => 'profile'
					))
				);
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/auth/profile');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_reset()
	{
		$this->template
			->title(__('Reset password'))
			->content(
				View_Model::factory('admin/page/auth/resetpassword')
				->bind('errors', $errors)
				->bind('user', $user)
				->bind('message_sent', $message_sent)
			);

		$user = ORM::factory('user');

		// Get and delete the message_sent status from session
		if ($message_sent = Session::instance()->get('message_sent', FALSE))
		{
			Session::instance()->delete('message_sent');
		}

		if ($this->request->method() === Request::POST)
		{
			try
			{
				// Try send reset passwork link in email
				$user->reset_password($this->request->post());

				// Store the result in session
				Session::instance()->set('message_sent', TRUE);

				// Redirect user to prevent refresh on POST request
				$this->request->redirect(URL::site($this->request->uri(array('action' => 'reset_password'))));
			}
			catch(Validation_Exception $e)
			{
				$errors = $e->array->errors('admin/auth/reset_password');

				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_confirm_reset_password()
	{
		$this->template
			->title(__('Reset password'))
			->content(
				View::factory('admin/page/auth/confirm_reset_password')
				->bind('errors', $errors)
				->bind('token', $token)
			);

		$token = $this->request->query('auth_token');
		$user  = ORM::factory('user', $this->request->query('id'));
		$hash  = $user->email . '+' . $user->password;

		if ( !$user->loaded() OR $token !== Cookie::get('token', FALSE) OR $token !== Auth::instance()->hash_password($hash))
		{
			throw new Exception(__('Invalid auth token.'));
		}

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$user->confirm_reset_password($this->request->post());

				// Remove token from cookie
	 			Cookie::delete('token');

				Message::set(Message::SUCCESS, __('Password successfully changed.'));

				$this->request->redirect(
					Route::get('admin')
					->uri(array(
						'controller' => 'auth',
						'action'     => 'signin'
					)) . '?username='.$user->username
				);
			}
			catch(Validation_Exception $e)
			{
				Message::set(Message::ERROR, __('Please correct the errors.'));
				$errors = $e->array->errors('admin/auth/changepass');
			}
			catch(ORM_Validation_Exception $e)
			{
				Message::set(Message::ERROR, __('Please correct the errors.'));
				$errors = $e->errors('admin/auth/changepass');
			}
		}
	}

	public function action_signout()
	{
		Auth::instance()->logout();

		$this->request->redirect('admin');
	}

}
