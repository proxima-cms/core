<?php defined('SYSPATH') or die('No direct script access.');
  
abstract class Controller_Admin_Base extends Controller_Base {
 
	// Set the admin master page
	public $template = 'admin/page/master_page';

	// Set the auto-crud model (optional)
	// Controller name must match this value
	public $crud_model = FALSE;

	// Items per page when listing items in model table
	public $pagination_items_per_page = 10;

	// Only users with role 'admin' can view this controller
	protected $auth_required = 'admin';
	
	public function before()
	{
		// If the crud model isn't set then use the controller name (default)
		$this->crud_model === FALSE AND $this->crud_model = $this->request->controller();
		
		$this->crud_model_singular = Inflector::singular($this->crud_model);
		
		parent::before();

		if ($this->auto_render)
		{
			$this->template->paths = array();
			$this->template->scripts = array();
			$this->template->styles = array();
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
			
			$this->template->styles = $styles;
			$this->template->scripts = $scripts; 
			$this->template->paths = $paths;
			$this->template->param = $this->request->param();
			$this->template->set_global('breadcrumbs', $this->get_breadcrumbs());
		}
				
		parent::after();
	}

	// A generic index action to show lists of model items
	public function action_index()
	{
		if (!$this->template->content)
		{
			$this->template->content = View::factory('admin/page/'.str_replace('_', '/', $this->request->controller()).'/index');
		}
		
		// Crud model needs to be set
		$this->crud_model === FALSE AND $this->request->redirect('admin');

		$this->template->title = __(ucfirst($this->crud_model));

		// Bind useful data objects to the view
		$this->template->content
			->bind($this->crud_model, $items)
			->bind('total', $total)
			->bind('page_links', $page_links);

		// Get the total amount of items in the table
		$total = ORM::factory( $this->crud_model_singular )->count_all();

		// Generate the pagination values
		$pagination = Pagination::factory(array(
			'total_items' => $total,
			'items_per_page' => $this->pagination_items_per_page,
			'view' => 'admin/pagination/asset_links'
		));

		// Get the items
		$items = ORM::factory( $this->crud_model_singular )
			->limit($pagination->items_per_page)
			->offset($pagination->offset)
			->find_all();

		// Generate the pagination links
		$page_links = $pagination->render();
	}

	public function authenticate()
	{
		// The user may be logged in but not have the correct permissions to view this controller and/or action, 
		// so instead of redirecting to signin page we redirect to 403 Forbidden
		if ( Auth::instance()->logged_in() AND Auth::instance()->logged_in($this->auth_required) === FALSE)
		{
			if (!$this->is_ajax)
			{
				$this->request->redirect('403');
			}
			else
			{
				exit(__('No permission.'));
			}
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
	
	// A generic delete action to delete a model item by ID
	public function action_delete($id = NULL, $set_message = TRUE)
	{
		if ($id === NULl)
		{
			$id = (int) Request::current()->param('id');
		}

		$item = ORM::factory($this->crud_model_singular, $id);

		if (!$item->loaded())
		{
			throw new Kohana_Exception('Item not found.');
		}

		$item->admin_delete(NULL, array('id' => $id));

		if ($set_message === TRUE)
		{
			$message = ucfirst($this->crud_model_singular).' '.__('successfully deleted.');			
			Message::set(Message::SUCCESS, $message);

			$this->request->redirect('admin/'.$this->crud_model);
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
