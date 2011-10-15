<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Assets extends Controller_Admin_Base {
	
	// Index filter vars
	protected $_assets;	
	
	protected $_pagination;
	
	protected $_total;
	
	protected $_order_by;
	
	protected $_direction;
	
	public function action_index($view = 'admin/page/assets/index')
	{
		$this->template->title = __('Assets');

		$this->template->content = View::factory($view)
			->bind('assets', $this->_assets)
			->bind('total', $this->_total)
			->bind('direction', $this->_direction)
			->bind('reverse_direction', $this->_reverse_direction)
			->bind('order_by', $this->_order_by)
			->bind('filter', $this->_filter)
			->bind('pagination', $this->_pagination);

		$this->_direction = Arr::get($_REQUEST, 'direction', 'asc');
		$this->_reverse_direction = $this->_direction === 'asc' ? 'desc' : 'asc';
		$this->_order_by = Arr::get($_REQUEST, 'sort', 'date');
		$this->_type = Arr::get($_REQUEST, 'type', 'all');
		$this->_subtype = Arr::get($_REQUEST, 'subtype', 'all');
		$this->_filter = Arr::get($_REQUEST, 'filter', NULL);

		// Get the total amount of items in the table
		$this->_total = ORM::factory('asset');
		
		$this->_filter_results($this->_total);
		$this->_total = $this->_total->count_all();

		// Generate the pagination values
		$this->_pagination = Pagination::factory(array(
			'total_items' => $this->_total,
			'items_per_page' => 18,
			'view'  => 'admin/pagination/asset_links'
		));

		switch($this->_order_by)
		{
			case 'type':
				$this->_order_by = 'mimetype_id';
				break;
			default:
				break;
		}

		$this->_assets = ORM::factory('asset')
			->order_by($this->_order_by, $this->_direction)			
			->limit($this->_pagination->items_per_page)
			->offset($this->_pagination->offset);

		$this->_filter_results($this->_assets);		
		$this->_assets = $this->_assets->find_all();
	}
	
	private function _filter_results(& $results)
	{
		if ($this->_filter)
		{
			list($name, $value) = explode('-', $this->_filter);

			foreach(explode('|', $value) as $value)
			{
				$results->or_where($name, '=', $value);
			}
		}		
	}

	public function action_upload($view_path = 'admin/page/assets/upload', $redirect_to = 'admin/assets')
	{
		$this->template->title = __('Admin - Upload assets');
		$this->template->content = View::factory($view_path)
			->bind('errors', $errors)
			->bind('allowed_upload_type', $allowed_upload_type)
			->bind('max_file_uploads', $max_file_uploads)
			->bind('field_name', $field_name);
		
		//array_push($this->template->scripts, 'modules/admin/media/js/jquery.uploadify.min.js');
		//array_push($this->template->scripts, 'modules/admin/media/js/jquery.multifile.pack.js');
		
		$allowed_upload_type = str_replace(',', ', ', Kohana::$config->load('admin/assets.allowed_upload_type'));
		$max_file_uploads = Kohana::$config->load('admin/assets.max_file_uploads');

		$field_name = 'asset';
		$assets = array();
		$errors = array();

		// Have files been uploaded?
		if ($_FILES AND isset($_FILES[$field_name]) AND is_array($_FILES[$field_name]))
		{
			// Loop through uploaded files
			foreach($_FILES[$field_name]['name'] as $c => $v)
			{			
				// Create the file upload array
				$file = array(
					$field_name => array(
						'name' 		=> $_FILES[$field_name]['name'][$c],
						'type' 		=> $_FILES[$field_name]['type'][$c],
						'tmp_name' 	=> $_FILES[$field_name]['tmp_name'][$c],
						'error'		=> $_FILES[$field_name]['error'][$c],
						'size' 		=> $_FILES[$field_name]['size'][$c]
					)
				);

				// Process the uploaded file and save data to db
				$asset = ORM::factory('asset')->admin_upload($file, $field_name);
				
				// Store the validation errors
				if ($error = $file->errors('admin/assets'))
				{
					$errors[$field_name][] = $error;	
				}
				// Else store the asset
				else
				{
					$assets[] = $asset;
				}
			}
		}
		// Upload fail!
		if ($errors)
		{
			if (isset($errors[$field_name]) and count($errors[$field_name]))
			{
				$c = count($errors[$field_name]);
			
				$message = ($c > 1) 
					? __(':errors_count assets were not uploaded.')
					: __(':errors_count asset was not uploaded.');
			
				Message::set(Message::ERROR, __($message, array(':errors_count' => $c)));
			}
		}
		// Upload success!
		else if ($_FILES AND $assets)
		{
			$c = count($assets);

			$message = ($c > 1)
				? __(':assets_count assets successfully uploaded.')
				: __(':assets_count asset successfully uploaded.');

			Message::set(Message::SUCCESS, __($message, array(':assets_count' => $c)));
	
			$this->request->redirect($redirect_to);
		}
		
		//$_POST = $_POST->as_array();
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
		$id = $this->request->param('id');

		$assets = (int) $id ? $id : Arr::get($_GET, 'assets', '');
		
		foreach($assets = explode(',', $assets) as $id)
		{
			$item = ORM::factory( $this->crud_model_singular, (int) $id);

			if (!$item->loaded()) continue;

			// Delete the asset from db and filesystem
			$data = array('id' => $id);
			if ($item->admin_delete(NULL, $data))
			{
				$file = DOCROOT.Kohana::$config->load('assets.upload_path').'/'.$item->filename;
				try
				{
					unlink($file);
				} 
				catch(Exception $e)
				{
					// Log this
				}
			}
			
			// Delete the resized image assets from db and filesystem
			foreach($item->sizes->find_all() as $resized)
			{
				$data = array('id' => $resized->id);

				if ($resized->admin_delete(NULL, $data))
				{
					$resized_file = DOCROOT.Kohana::$config->load('assets.upload_path').'/resized/'.$resized->filename;
					try
					{
						unlink($resized_file);
					}
					catch(Exception $e)
					{
						// Log this
					}
				}
			}
		}		
		if (count($assets))
		{
			Message::set(Message::SUCCESS, ucfirst($this->crud_model).' successfully deleted.');
		}
			
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
				
				// Generate a PNG thumbnail of the PDF
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
		
		echo View::factory('admin/page/assets_popup/download_html')->set('asset', $asset);
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
