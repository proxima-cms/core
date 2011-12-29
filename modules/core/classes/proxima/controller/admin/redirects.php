<?php 

class Proxima_Controller_Admin_Redirects extends Controller_Admin_Base {

	public function action_add()
	{
		$this->template->title = __('Add redirect');

		$this->template->content = View::factory('admin/page/redirects/add')
			->bind('pages', $pages)
			->bind('errors', $errors);

		$pages = ORM::factory('page')->tree_select(4, 0, array('' => __('None')), 0, 'title');

		if ($_POST)
		{		
			if (ORM::factory('redirect')->admin_add($_POST))
			{		
				Message::set(Message::SUCCESS, __('Redirect successfully saved.'));
				$this->request->redirect('admin/redirects');
			}		
			else if ($errors = $_POST->errors('admin/redirects'))
			{		
				 Message::set(Message::ERROR, __('Please correct the errors.'));
			}		

			$_POST = $_POST->as_array();
		}		
	}	
	
	public function action_edit()
	{
		$id = (int) $this->request->param('id');

		$redirect = ORM::factory('redirect', $id);

		if (!$redirect->loaded())
		{
			throw new HTTP_Exception_500('Redirect not found.');
		}

		$this->template->title = __('Edit redirect');

		$this->template->content = View::factory('admin/page/redirects/edit')
			->bind('pages', $pages)
			->bind('redirect', $redirect)
			->bind('errors', $errors);

		$pages = ORM::factory('page')->tree_select(4, 0, array('' => __('None')), 0, 'title');

		if ($_POST)
		{		
			if ($redirect->admin_update($_POST))
			{		
				Message::set(Message::SUCCESS, __('Redirect successfully saved.'));
				$this->request->redirect($this->request->uri());
			}		
			else if ($errors = $_POST->errors('admin/redirects'))
			{		
				 Message::set(Message::ERROR, __('Please correct the errors.'));
			}		
		}		
		else
		{		
			$_POST = $redirect->as_array();
		}  
	}	

}
