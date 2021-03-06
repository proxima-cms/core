<?php defined('SYSPATH') or die('No direct script access.');
/**
 * The Bbse controller
 * Handles:
 *  - Base templating (through a view model)
 *  - Authentication
 *  - Sending the response (handling AJAX responses)
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
abstract class Proxima_Controller_Base extends Controller {

	public $auto_render = TRUE;

	public $view_model = NULL;

	public $template = NULL;

	protected $_auth_required = FALSE;

	public function before()
	{
		// The user may be logged in but not have the correct permissions to view this controller and/or action,
		// so instead of redirecting to signin page we redirect to 403 Forbidden
		if ( Auth::instance()->logged_in() AND Auth::instance()->logged_in($this->_auth_required) === FALSE)
		{
			$this->request->redirect('403');
		}

		// If this page is secured and the user is not logged in (or doesn't match role), then redirect to the signin page
		if ($this->_auth_required !== FALSE && Auth::instance()->logged_in($this->_auth_required) === FALSE)
		{
			Message::set(Message::ERROR, __('You need to be signed in to do that.'));

			// Generate the signin URL
			$uri = Route::get('admin')
				->uri(array(
					'controller' => 'auth',
					'action' => 'signin'
				));

			// Set the return path so user is redirect back to this page after successful sign in.
			$uri .= '?return_to=' . $this->request->uri();

			$this->request->redirect($uri);
		}

		// Create the global template view-model
		$this->template = View_Model::factory($this->view_model);
	}

	public function after()
	{
		// If it's an AJAX or HMVC internal request then only render the INNER template
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
