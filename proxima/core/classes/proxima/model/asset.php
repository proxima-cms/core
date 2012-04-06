<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Asset extends Model_Base {

	protected $_belongs_to = array(
		'mimetype' => array(
			'model' => 'mimetype',
			'foreign_key' => 'mimetype_id'
		),
		'user' => array(
			'model' => 'user',
			'foreign_key' => 'user_id'
		),
		'asset_folder' => array(
			'model' => 'asset_folder',
			'foreign_key' => 'folder_id'
		)
	);

	protected $_has_many = array(
		'sizes' => array('model' => 'asset_size', 'foreign_key' => 'asset_id'),
	);

	public function upload_rules($fieldname = 'assets')
	{
		return array(
			"{$fieldname}" => array(
				array('Upload::not_empty', array(':value')),
				array('Upload::valid'),
				array('Upload::size', array(':value', '10M')),
				array(array($this, 'mimetype_exists')),
				array('Upload::type', array(':value', explode(',', Kohana::$config->load('admin/assets.allowed_upload_type'))))
			)
		);
	}

	public function rules()
	{
		return array(
			'filename' => array(
				array('not_empty'),
				array('max_length', array(':value', array(128))),
				array(array($this, 'filename_empty'))
			),
			'description' => array(
				array('not_empty'),
				array('max_length', array(':value', array(255))),
			)
		);
	}

	// Check mimetype exists by extension
	public function mimetype_exists($file)
	{
		return ORM::factory('mimetype')
			->where('extension', '=', Asset::extension($file['name']))
			->find()
			->loaded();
	}

	// Check if filename is empty (remove the entension)
	public function filename_empty($filename)
	{
		return (preg_replace('/\.\w+$/', '', $filename) === '') ? FALSE : $filename;
	}

	public function resize($path, $width = NULL, $height = NULL, $crop = NULL)
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::resize($file, $path, $width, $height, $crop);
		}
	}

	public function rotate($degrees = 90)
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::rotate($file, $degrees);
		}
	}

	public function sharpen($amount = 20)
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::rotate($file, $amount);
		}
	}

	public function flip_horizontal()
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::flip_horizontal($file);
		}
	}
	public function flip_vertical()
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::flip_vertical($file);
		}
	}

	public function url($full = FALSE)
	{
		return Asset::url($this, $full);
	}

	public function path($full = FALSE)
	{
		$path = Kohana::$config->load('assets.upload_path').'/'.$this->filename;

		return Asset::path($this, $full);
	}

	public function image_url($width = NULL, $height = NULL, $crop = NULL, $full_path = FALSE)
	{
		return Asset::image_url($this, $width, $height, $crop, $full_path);
	}

	public function image_path($width = NULL, $height = NULL, $crop = NULL, $full_path = FALSE)
	{
		return Asset::image_path($this, $width, $height, $crop, $full_path);
	}

	public function is_image()
	{
		return ($this->mimetype->subtype == 'image');
	}

	public function is_pdf()
	{
		return ($this->mimetype->subtype == 'application' AND $this->mimetype->type == 'pdf');
	}

	public function is_text_document()
	{
		return ($this->mimetype->subtype == 'text');
	}

	public function is_archive()
	{
		return ($this->mimetype->subtype == 'application' AND ($this->mimetype->type == 'x-tar' OR $this->mimetype->type == 'zip'));
	}

	public function filter($filter = array())
	{
		if (!is_array($filter))
		{
			if ($filter === NULL)
			{
				$filter = array();
			}
			else
			{
				list($name, $value) = explode('-', $filter);

				$filter = array();

				foreach(explode('|', $value) as $value)
				{
					$filter[$name] = $value;
				}
			}
		}

		foreach($filter as $name => $value)
		{
			$this->or_where($name, '=', $value);
		}

		return $this;
	}

	public function search($query)
	{
		return ($query === NULL OR $query === FALSE) ? $this : $this->where(
			DB::expr('MATCH(asset.description, asset.filename)'),
			'',
			DB::expr('AGAINST(' . Database::instance()->escape($query) . ')')
		);
	}

	public function __get($key) {

		if (($key === 'width' OR $key === 'height') AND $this->is_image())
		{
			try
			{
				$image_size = getimagesize($this->path(TRUE));

				if ($image_size)
				{
					return ($key == 'width') ? $image_size[0] : $image_size[1];
				}
			}
			catch(Exception $e){}
		}

		return parent::__get($key);
	}

	public function admin_upload($files = array(), $data = array(), $field_name = 'assets')
	{
		// Have files been uploaded?
		if (isset($files[$field_name]) AND is_array($files[$field_name]))
		{
			// Loop through uploaded files
			foreach($files[$field_name]['name'] as $c => $v)
			{
				// Create the file upload array
				$file = array(
					"{$field_name}" => array(
						'name'     => $files[$field_name]['name'][$c],
						'type'     => $files[$field_name]['type'][$c],
						'tmp_name' => $files[$field_name]['tmp_name'][$c],
						'error'    => $files[$field_name]['error'][$c],
						'size'     => $files[$field_name]['size'][$c]
					)
				);

				$file = Validation::factory($file);

				foreach($this->upload_rules($field_name) as $field => $rules)
				{
					$file->rules($field, $rules);
				}

				if ($file->check() === FALSE)
				{
					throw new Validation_Exception($file);
				}

				$file = $file[$field_name];
				$name = strtolower($file['name']);
				$path = DOCROOT.Kohana::$config->load('assets.upload_path');

				$file_path = Upload::save($file, $name, $path);

				if ($file_path === FALSE)
				{
					throw new Exception(__('Unable to move the uploaded file.'));
				}

				$data['file_path'] = $file_path;

				$this->admin_create_uploaded($data);
			}
		}
		else
		{
			throw new Exception(__('No files were uploaded.'));
		}
	}

	public function admin_create_uploaded($data = array())
	{
		$file_path   = $data['file_path'];
		$file_name   = basename($file_path);
		$extension   = Asset::extension($file_name);
		$description = Asset::description($file_name);

		$mimetype = ORM::factory('mimetype')
			->where('extension', '=', $extension)
			->find();

		$data = array(
			'user_id'           => Auth::instance()->get_user()->id,
			'mimetype_id'       => $mimetype->id,
			'folder_id'         => $data['folder_id'],
			'filename'          => $file_name,
			'friendly_filename' => $file_name,
			'description'       => $description,
			'filesize'          => filesize($file_path)
		);

		$this->values($data);
		$this->save();

		// Create a new filename with id prefixed
		$new_filename   = str_replace($this->filename, $this->id.'_'.$this->filename, $file_path);
		$this->filename = basename($new_filename);
		$this->save();

		// Move the file to the new filename path
		rename($file_path, $new_filename);
	}

	public function admin_update($data)
	{
		$this->values($data);

		return $this->save();
	}

	public function admin_delete()
	{
		// Try delete the asset from the filesystem.
		try
		{
			unlink(DOCROOT.Kohana::$config->load('assets.upload_path').'/'.$this->filename);
		}
		catch(Exception $e)
		{
			Log::instance()->add(Log::ERROR, $e->getMessage());
		}

		foreach($this->sizes->find_all() as $resized)
		{
			// Try delete the resized asset from the filesystem.
			try
			{
				unlink(DOCROOT.Kohana::$config->load('assets.upload_path').'/resized/'.$resized->filename);
			}
			catch(Exception $e)
			{
				Log::instance()->add(Log::ERROR, $e->getMessage());
				throw $e;
			}

			$resized->delete();
		}

		return parent::delete();
	}
} // End Model_Asset
