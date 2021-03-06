<?php defined('SYSPATH') or die('No direct access allowed.');

class Proxima_Component_Driver_Contact_Form extends Component_Component {

	public $_default_config = array(
		'recipient' => 'null@example.com',
		'subject' => 'Default subject'
	);

	public function render()
	{
		$data = Request::initial()->post();

		die(print_r($data));

		$view = View::factory('components/contact/form/form')
			->bind('errors', $errors);

		$data = Validation::factory($data)
			->rule('name', 'not_empty')
			->rule('email', 'not_empty')
			->rule('email', 'email');

		if (Request::current()->method() === 'POST' && $data->check())
		{
	 		// Get the email content
			$email_body    = $data['message'];
			$email_subject = __($this->_config['subject'], array(':name' => $data['name']));

			// Send the email
			$email = Email::factory($email_subject, $email_body)
				->to($this->_config['recipient'])
				->from($data['email'], $data['name'])
				->send();

			Message::set(Message::SUCCESS, __('Message successfully sent.'));

			Request::current()->redirect(Request::current()->uri());
		}

		if ($errors = $data->errors('contact'))
		{
			Message::set(Message::ERROR, __('Please correct the errors.'));
		}

		$this->template->content = $view;
	}
}
