<?php 

class Controller_Admin_BlogImport extends Controller_Admin_Base {

	/**
	 * Index action. Shows the import form and handles validation.
	 *
	 * @return  void
	 */
	public function action_index()
	{
		Page_View::instance()
			->title(__('Admin - Blog import'))
			->content(
				View_Model::factory('admin/page/blogimport/index')
				->bind('errors', $errors)
			); 

		$data = Validation::factory($_POST)
			->rule('blog_url', 'not_empty')
			->rule('blog_url', 'url');

		if ($this->request->method() === Request::POST AND $data->check())
		{
			$result = Importer::factory($this->request->post('service'), $this->request->post())
				->import_posts();
	
			if ($result === FALSE)
			{
				Message::set(Message::ERROR, __('Error loading the XML feed.'));

				Request::current()->redirect('admin/blogimport');
			} 
			
			$message = sprintf('Saved %s of %s posts.', 
				$result['saved'],
				$result['total_posts']
			);
				
			Message::set($result > 0 ? Message::SUCCESS : Message::NOTICE, $message);

			Request::current()->redirect('admin/blogimport');
		}
		else
		{
			$errors = $data->errors('blogimport');
		}
	}
}
