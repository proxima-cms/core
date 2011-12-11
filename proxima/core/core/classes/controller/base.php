<?php defined('SYSPATH') or die('No direct script access.');
	
abstract class Controller_Base extends Controller {
 
	public $auto_render = TRUE;

	public $master_template = NULL;

	protected $auth_required = FALSE;

	public function before()
	{
		// The user may be logged in but not have the correct permissions to view this controller and/or action, 
		// so instead of redirecting to signin page we redirect to 403 Forbidden
		if ( Auth::instance()->logged_in() AND Auth::instance()->logged_in($this->auth_required) === FALSE)
		{   
			$this->request->redirect('403');
		}   

		// If this page is secured and the user is not logged in (or doesn't match role), then redirect to the signin page
		if ($this->auth_required !== FALSE && Auth::instance()->logged_in($this->auth_required) === FALSE)
		{   
			Message::set(Message::ERROR, __('You need to be signed in to do that.'));

			// Set the return path so user is redirect back to this page after successful sign in
			$uri = 'admin/auth/signin?return_to=' . $this->request->uri();

			$this->request->redirect($uri);
		}   

		// Create the front-end page
		Page_View::instance(array(
			'view'   => $this->master_template,
			'render' => $this->auto_render
		));
	}

	public function after()
	{
		// Render the front-end page
		Page_View::instance()->render();
	}

} // End Controller_Base
