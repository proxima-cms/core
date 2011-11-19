<?php 

class Controller_Admin_BlogImport extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template->title = __('Blog import');
		$this->template->content = View::factory('admin/page/blogimport/index')
			->bind('pages', $pages)
			->bind('page_types', $page_types)
			->bind('errors', $errors);

		$pages = ORM::factory('page')->tree_select(4, 0, array(__('None')), 0, 'title');

		$page_types = array();
		foreach($types = ORM::factory('page_type')->find_all() as $type)
		{
			$page_types[$type->id] = $type->name;
		}

		$data = Validation::factory($_POST)
			->rule('blog_url', 'not_empty')
			->rule('blog_url', 'url');

		if ($_POST AND $data->check())
		{
			$result = Importer::factory($_POST['service'], $_POST)->import_posts();
	
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
