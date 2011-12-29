<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Auth extends Controller_Admin_Base {

	public $master_template = 'admin/page/auth/master_page';

	public $auth_required = FALSE;

	public function action_signin()
	{
		// Redirect if user is logged in
		if (Auth::instance()->logged_in())
		{
			$this->request->redirect('admin');
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
				$data = $this->request->post();
				
				$user->login($data);

				Message::set(Message::SUCCESS, __(':username successfully signed in.', array(':username' => $user->username)));

				$return = Arr::get($this->request->post(), 'return_to', 'admin');

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
		// Redirect if user is logged in
		Auth::instance()->logged_in() AND $this->request->redirect('');		

		// Set template vars
		$this->template->title = __('Sign up'); 
		$this->template->content = View::factory('page/auth/signup')
			->bind('errors', $errors);

		// If successful signup then redirect to login page
		if (ORM::factory('user')->signup($_POST)){
			
			$message = $_POST['username'].' successfully registerd.';
			Message::set(Message::SUCCESS, __($message));
			
			$this->request->redirect('');			
		}
		
		if ($errors = $_POST->errors('signup'))
		{
			 Message::set(Message::ERROR, __('Please correct the errors.'));
		}

		$_POST = $_POST->as_array();
	}

	public function action_profile()
	{
		// Redirect if user is logged in
		!Auth::instance()->logged_in() AND $this->request->redirect('user/signin');
		
		$this->template->title = __('Profile');
		$this->template->content = View::factory('page/auth/profile')
			->bind('errors', $errors);
			
		$user = Auth::instance()->get_user();

		// Update logged in user details, if successfull then redirect to profile page
		if ($user->update($_POST)){
			
			$message = $user->username.' profile updated.';
			Message::set(Message::SUCCESS, __($message));
				
			$this->request->redirect('user/profile');
		}
		
		if ($errors = $_POST->errors('profile'))
		{
			 Message::set(Message::ERROR, __('Please correct the errors.'));
		}
	}

	public function action_reset()
	{
		$this->template->title = __('Reset password');
		$this->template->content = View::factory('admin/page/auth/reset_password')
			->bind('errors', $errors)
			->bind('message_sent', $message_sent);

		// Get and delete the message_sent status from session
		if ($message_sent = Session::instance()->get('message_sent', FALSE))
		{
			Session::instance()->delete('message_sent');
		}

		if ($_POST)
		{
			// Try send reset passwork link in email
			if ( ORM::factory('user')->reset_password($_POST))
			{
				// Store the result in session FIXME use messages class
				Session::instance()->set('message_sent', TRUE);

				// Redirect user to prevent refresh on POST request
				$this->request->redirect(URL::site($this->request->uri(array('action' => 'reset_password'))));
			}
			else
			{
					$errors = $_POST->errors('reset_password');
					Message::set(Message::ERROR, __('Please correct the errors.'));
			}

		}
	}

	public function action_confirm_reset_password()
	{
		$this->template->title = __('Reset password');
		$this->template->content = View::factory('admin/page/auth/confirm_reset_password')
			->set('token', @$_REQUEST['auth_token'])
			->bind('errors', $errors);
		
		$id = (int) Arr::get($_REQUEST, 'id');
		$token = (string) Arr::get($_REQUEST, 'auth_token');

		if ($_POST)
		{

			$user = ORM::factory('user', $id);

			if (!$user->loaded())
			{
				throw new Exception('User not found.');
			}

			if ($user->confirm_reset_password($_POST, $token))
			{
				Message::set(Message::SUCCESS, __('Password successfully changed.'));
				$this->request->redirect('admin/auth/signin?username='.$user->username);
			}
			else if ($errors = $_POST->errors('confirm_reset_password'))
			{
				Message::set(Message::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_signout()
	{
		Auth::instance()->logout();

		$this->request->redirect('admin');
	}

} // End Controller_Auth_Auth
