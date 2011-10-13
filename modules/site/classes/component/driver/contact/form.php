<?php defined('SYSPATH') or die('No direct access allowed.');

class Component_Driver_Contact_Form extends Component_Component {

	public $_default_config = array(
		'recipient' => 'null@example.com',
		'subject' => 'Default subject'
	);

	public function render()
	{
		$view = View::factory(Theme::path('components/contact/form/form'))
			->bind('errors', $errors);

		$data = Validation::factory($_POST)
			->rule('name', 'not_empty')
			->rule('email', 'not_empty')
			->rule('email', 'email');

		if ($_POST AND $data->check())
		{
			$swift_loader = Kohana::find_file('classes', 'component/driver/contact/vendor/swiftmailer/lib/swift_required');

			if ($swift_loader === FALSE)
			{
				throw new Kohana_Exception('Swiftmailer library not found.');
			}

			require_once $swift_loader;

			$transport = Swift_MailTransport::newInstance();
			$mailer = Swift_Mailer::newInstance($transport);
			
			// Create an email message
			$message = Swift_Message::newInstance()
				->setSubject(__($this->_config['subject'], array(':name' => $data['name'])))
				->setFrom(array($data['email'] => $data['name']))
				->setTo($this->_config['recipient'])
				->addPart($data['message'], 'text/plain');

			// Send the message
			Swift_Mailer::newInstance($transport)->send($message);

			Message::set(Message::SUCCESS, __('Message successfully sent.'));
			
			Request::current()->redirect(Request::current()->uri());
		}

		if ($errors = $data->errors('contact'))
		{
			Message::set(Message::ERROR, __('Please correct the errors.'));
		}
		
		return $view->render();
	}
}
