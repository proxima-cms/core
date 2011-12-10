<?php defined('SYSPATH') or die('No direct script access.');
	
abstract class Controller_Admin_Base extends Controller_Base {
 
	// Set the admin master page
	public $template = 'admin/page/master_page';

	// Only users with role 'admin' can view this controller
	protected $auth_required = 'admin';
	
	public function before()
	{
		parent::before();

		if ($this->auto_render)
		{
			$this->template->paths   = array();
			$this->template->scripts = array();
			$this->template->styles  = array();
		}
	}
	
	public function after()
	{
		if ($this->auto_render)
		{
			// Merge in the generic admin config with the controller config.
			$styles = array_merge(
				(array) Kohana::$config->load('admin/media.styles'), 
				(array) Kohana::$config->load('admin/'.$this->request->controller().'.styles'),
				(array) $this->template->styles
			);
			
			$scripts = array_merge(
				(array) Kohana::$config->load('admin/media.scripts'), 
				(array) Kohana::$config->load('admin/'.$this->request->controller().'.scripts'),
				(array) $this->template->scripts
			);

			$paths = array_merge(
				(array) Kohana::$config->load('admin/media.paths'),
				(array) Kohana::$config->load('admin/'.$this->request->controller().'.paths'),
				(array) $this->template->paths
			);
			
			$this->template->styles  = $styles;
			$this->template->scripts = $scripts; 
			$this->template->paths   = $paths;
			$this->template->param   = $this->request->param();
			$this->template->set_global('breadcrumbs', $this->get_breadcrumbs());

			if ($this->template->content === NULL)
			{
				// $class_name = get_class($this);
				// TODO: set the view from the class name & method
			}
		}
				
		parent::after();
	}

	public function authenticate()
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
	}
	
	public function get_breadcrumbs($pages = array())
	{
		foreach($segments = explode('/', $this->request->uri()) as $key => $page)
		{
			$pages[] = array(
				'title' => $page,
				'url'	=> URL::site(join('/', array_slice($segments, 0, ($key + 1))))
			);
		}
		
		return View::factory('admin/page/fragments/breadcrumbs')->set('pages', $pages);
	}

} // End Controller_Admin_Base
