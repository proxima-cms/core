<?php defined('SYSPATH') or die('No direct script access.');

abstract class Proxima_Controller_Base extends Controller {

	public $auto_render = TRUE;

	public $view_model = NULL;

	public $template = NULL;

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

		// Create the global template view-model
		$this->template = View_Model::factory($this->view_model);
	}

	public function after()
	{
		// If it's an AJAX or HMVC request then only render the INNER template
		if ($this->request->is_ajax() OR Request::initial() !== $this->request OR $this->auto_render === FALSE)
		{
			$this->request->response()->body($this->template->content);
		}
		// Else render the master template
		else if ($this->auto_render === TRUE)
		{
			// Render the master template
			$this->request->response()->body($this->template);
		}
	}

} // End Controller_Base
