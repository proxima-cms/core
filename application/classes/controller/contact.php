<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Contact extends Controller_Base {

	public function action_index()
	{
		$this->template->title = __('Contact');
		$this->template->content = View::factory('page/contact')
			->bind('errors', $errors)
			->bind('post', $post);
		
		// Validate the required fields
		$data = Validation::factory($_POST)
			->rule('name', 'not_empty')
			->rule('email', 'not_empty')
			->rule('email', 'email')
			->rule('message', 'not_empty');

		if ($data->check())
		{
			// Load Swift Mailer
			require Kohana::find_file('vendor', 'swiftmailer/lib/swift_required');

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
			
			// Get the email config
			$config = Kohana::config('site.contact');
			$recipient = $config['recipient'];
			$subject = $config['subject'];
			
			// Create an email message
			$message = Swift_Message::newInstance()
				->setSubject(__($subject, array(':name' => $data['name'])))
				->setFrom(array($data['email'] => $data['name']))
				->setTo($recipient)
				->addPart($data['message'], 'text/plain');

			// Send the message
			Swift_Mailer::newInstance($transport)->send($message);

			// Set the activity and flash message
			Activity::set(Activity::SUCCESS, __('Message sent from :email', array(':email' => $data['email'])));
			Message::set(Message::SUCCESS, __('Message successfully sent.'));
			
			// Redirect to prevent POST refresh	
			$this->request->redirect($this->request->uri);
		}

		if ($errors = $data->errors('contact'))
		{
			// Set the error flash message
			Message::set(Message::ERROR, __('Please correct the errors.'));
		}
		
		$post = $data;
	}

} // End Controller_Contact
