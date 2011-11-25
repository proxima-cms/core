<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Assets extends Controller_Admin_Base {
	
	public function before()
	{
		parent::before();

		$this->template->scripts = array_merge($this->template->scripts, Kohana::$config->load('admin/assets/popup.scripts'));
		$this->template->styles  = array_merge($this->template->styles, Kohana::$config->load('admin/assets/popup.styles'));
	}

	public function action_index($view = 'admin/page/assets/index')
	{
		$this->template->title = __('Assets');

		$this->template->content = View::factory($view)
			->bind('assets', $assets)
			->bind('total', $total)
			->bind('direction', $direction)
			->bind('reverse_direction', $reverse_direction)
			->bind('order_by', $order_by)
			->bind('filter', $filter)
			->bind('search', $search)
			->bind('links', $filter_links)
			->bind('pagination', $pagination);

		// Get request vars.
		$request           = $this->request->query();
		$direction         = Arr::get($request, 'direction', 'asc');
		$reverse_direction = $direction === 'asc' ? 'desc' : 'asc';
		$order_by          = Arr::get($request, 'sort', 'date');
		$type              = Arr::get($request, 'type', 'all');
		$subtype           = Arr::get($request, 'subtype', 'all');
		$filter            = Arr::get($request, 'filter');
		$search            = $this->request->post('search') OR Arr::get($request, 'search');
		$items_per_page    = 18;
		$filter_links      = $this->get_filter_links($direction);

		// Get the total amount of filtered assets.
		$total = ORM::factory('asset')
			->join('mimetypes')
			->on('asset.mimetype_id', '=', 'mimetypes.id')
			->filter($filter)
			->search($search)
			->count_all();

		// Generate the pagination values.
		$pagination = Pagination::factory(array(
			'total_items'    => $total,
			'items_per_page' => $items_per_page,
			'view'           => 'admin/pagination/asset_links'
		));

		// Adjust the order_by value.
		switch($order_by)
		{
			case 'type':
				$order_by = 'mimetype_id';
				break;
			default:
				break;
		}

		// Get the filtered assets.
		$assets = ORM::factory('asset')
			->join('mimetypes')
			->on('asset.mimetype_id', '=', 'mimetypes.id')
			->order_by($order_by, $direction)			
			->limit($items_per_page)
			->offset($pagination->offset)
			->filter($filter)
			->search($search)
			->find_all();
	}

	private function get_filter_links($direction = NULL)
	{
		$link = 'admin/assets?direction='.$direction;

		return array(
			'links' => array(
				'all' => $link,
				'img' => $link.'&filter=subtype-image',
				'doc' => $link.'&filter=type-pdf|doc|txt',
				'arc' => $link.'&filter=type-tar|zip|rar'
			),	
			'cur_url' => urldecode(Request::current()->uri() . URL::query())
		);
	}

	public function action_upload($view_path = 'admin/page/assets/upload', $redirect_to = 'admin/assets')
	{
		$this->template->title = __('Admin - Upload assets');
		$this->template->content = View::factory($view_path)
			->bind('errors', $errors)
			->bind('allowed_upload_type', $allowed_upload_type)
			->bind('max_file_uploads', $max_file_uploads)
			->bind('field_name', $field_name);
		
		$allowed_upload_type = str_replace(',', ', ', Kohana::$config->load('admin/assets.allowed_upload_type'));
		$max_file_uploads    = Kohana::$config->load('admin/assets.max_file_uploads');
		$field_name          = 'asset';
		$uploaded_files			 = $_FILES;

		if ($this->request->method() === 'POST')
		{
			try
			{
				$uploaded = ORM::factory('asset')->admin_upload($uploaded_files, $field_name);
			}
			// Error validating the uploaded files.
			catch(Validation_Exception $e)
			{
				$errors = $e->array->errors('admin/assets');
			}
			// Error processing the uploaded files.
			catch(Exception $e)
			{
				throw $e;
			}
			// Error saving the file data to the db.
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/assets');
			}

			if ($errors === NULL)
			{
				$message = ($uploaded > 1)
					? __(':assets_count assets successfully uploaded.')
					: __(':assets_count asset successfully uploaded.');
			
				Message::set(Message::SUCCESS, __($message, array(':assets_count' => $uploaded)));

				$this->request->redirect($redirect_to);
			}
			else
			{
				$message = __('Error uploading files.');

				Message::set(Message::ERROR, __($message, array(':errors_count' => count($errors))));
			}
		}
	}
	
	public function action_edit()	
	{
		$id = (int) $this->request->param('id');

		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded())
		{
			Message::set(MESSAGE::ERROR, __('Asset not found.'));
			$this->request->redirect('admin/assets');
		} 
		
		$this->template->title = __('Admin - Edit asset');
		$this->template->content = View::factory('admin/page/assets/edit')
			->set('resized', $asset->sizes->where('resized', '=', 1)->find_all())
			->set('links', $this->get_filter_links())
			->bind('asset', $asset)
			->bind('errors', $errors);

		if (!$_POST)
		{
			$_POST = $asset->as_array();
		}
		else
		{
			if ($asset->admin_update($_POST))
			{
				Message::set(Message::SUCCESS, __('Asset successfully updated.'));			
				$this->request->redirect($this->request->uri());
			}
			else
			{
				$errors = $_POST->errors('admin/assets');
				Message::set(MESSAGE::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_download()
	{
		$id = $this->request->param('id');

		$asset = ORM::factory('asset', (int) $id);

		if (!$asset->loaded())
		{
			exit;
		}

		$this->response->send_file($asset->path(TRUE), $asset->friendly_filename);
	}
	
	public function action_delete($id = NULL, $set_message = TRUE)
	{	
		$assets = $this->request->param('id') ?: $this->request->query('assets');
		
		foreach($assets = explode(',', $assets) as $id)
		{
			$item = ORM::factory('asset', $id);

			if (!$item->loaded())
			{
				continue;
			}

			$item->admin_delete();
		}		
		
		Message::set(Message::SUCCESS, 'Asset successfully deleted.');
			
		$this->request->redirect('admin/assets');
	}
	
	public function action_get_asset()
	{	
		$this->auto_render = FALSE;

		$id = (int) $this->request->param('id');
		$width = (int) $this->request->param('width');
		$height = (int) $this->request->param('height');
		$crop = (int) $this->request->param('crop');
		$filename = $this->request->param('filename');

		if (!$id OR !$width OR !$height OR !$filename)
		{
			exit;
		}
		
		$filename = "{$id}_$filename";

		$asset = ORM::factory('asset')
			->where('id', '=', $id)
			->find();

		if (!$asset->loaded() OR !file_exists($asset->image_path(NULL, NULL, NULL, TRUE)))
		{
			exit;
		}

		// Check the image size exists
		$size = ORM::factory('asset_size')
			->where('asset_id', '=', $asset->id)
			->where('width', '=', $width)
			->where('height', '=', $height)
			->where('crop', '=', $crop)
			->find();
			
		$path = $asset->image_path($width, $height, $crop, TRUE);

		if ($size->loaded() AND !file_exists($path))
		{			
			$this->request->headers['Content-Type'] = $asset->mimetype->subtype.'/'.$asset->mimetype->type;
			
			if ($asset->mimetype->subtype === 'application' AND $asset->mimetype->type == 'pdf')
			{
				$file_in = DOCROOT.Kohana::$config->load('assets.upload_path').'/'.$asset->filename;
				
				// Generate an image thumbnail of the PDF
				Asset::pdfthumb($file_in, $path, $width, $height, $crop);
			}
			else
			{
				$asset->resize($path, $width, $height, $crop);
			}
		
			$size->filesize = filesize($path);
			$size->resized = 1;
			$size->save();
			
			$this->response->send_file($path, FALSE, array('inline' => true));			
		}	
	}
	
	public function action_get_url()
	{
		$id = $this->request->param('id');

		$this->auto_render = FALSE;
		
		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded()) exit;
		
		echo $asset->url(TRUE);
	}
	
	public function action_get_image_url()
	{
		$id = $this->request->param('id');
		$width = $this->request->param('width');
		$height = $this->request->param('height');

		$this->auto_render = FALSE;
		
		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded() OR $asset->mimetype->subtype != 'image') exit;
		
		echo $asset->image_url($width, $height, NULL, TRUE);
	}
	
	public function action_get_download_html()
	{
		$id = $this->request->param('id');

		$this->auto_render = FALSE;
		
		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded()) exit;
		
		echo View::factory('admin/page/assets/popup/download_html')->set('asset', $asset);
	}	
	
	public function action_rotate()
	{
		$id = $this->request->param('id');

		$asset = ORM::factory('asset', (int) $id);
		
		if (!$asset->loaded() OR $asset->mimetype->subtype !== 'image') exit;
		
		$asset->rotate(90);
		
		foreach($asset->sizes->find_all() as $asset_size){
			$asset_size->rotate(90);
		}

		$this->request->redirect('admin/assets/edit/'.$asset->id);
	}
	
	public function action_sharpen()
	{
		$id = $this->request->param('id');

		$asset = ORM::factory('asset', (int) $id);

		if (!$asset->loaded() OR $asset->mimetype->subtype !== 'image') exit;

		$asset->sharpen(20);

		$this->request->redirect('admin/assets/edit/'.$asset->id);
	}
	
	public function action_flip_horizontal()
	{
		$id = $this->request->param('id');

		$asset = ORM::factory('asset', (int) $id);

		if (!$asset->loaded() OR $asset->mimetype->subtype !== 'image') exit;

		$asset->flip_horizontal();

		$this->request->redirect('admin/assets/edit/'.$asset->id);
	}
	
	public function action_flip_vertical()
	{
		$id = $this->request->param('id');

		$asset = ORM::factory('asset', (int) $id);

		if (!$asset->loaded() OR $asset->mimetype->subtype !== 'image') exit;
		
		$asset->flip_vertical();

		$this->request->redirect('admin/assets/edit/'.$asset->id);
	}
	
} // End Controller_Admin_Assets
