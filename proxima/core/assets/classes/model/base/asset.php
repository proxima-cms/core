<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Base asset model
 */
class Model_Base_Asset extends Model_Base { 
	
	protected $_belongs_to = array(
		'mimetype' => array('model' => 'mimetype', 'foreign_key' => 'mimetype_id'),
		'user'     => array('model' => 'user', 'foreign_key' => 'user_id'),
	);
	
	protected $_has_many = array(
		'sizes' => array('model' => 'asset_size', 'foreign_key' => 'asset_id'),
	);

	public function upload_rules()
	{
		return array(
			'asset' => array(
				array('Upload::not_empty', array(':value')),
				array('Upload::valid'),
				array('Upload::size', array(':value', '10M')),
				array('Model_Base_Asset::validate_mimetype_exists'),
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
			),
			'description' => array(
				array('not_empty'),
				array('max_length', array(':value', array(255))),
			)
		);
	}
	
	// Validation callbacks
	protected $_callbacks = array(
		'upload' => array(
			'extension' => array('callback_mimetype_exists'),
		),
		'update' => array(
			'filename' => array('callback_filename_empty'),
		),
	);
	
	// Check mimetype exists by extension
	public static function validate_mimetype_exists($file)
	{
		return ORM::factory('mimetype')
			->where('extension', '=', Asset::extension($file['name']))
			->find()
			->loaded();
	}

	// Check if filename is empty
	public function callback_filename_empty(Validate $array, $field)
	{
		$val = $array[$field];

		// Strip extension
		if (preg_replace('/\.\w+$/', '', $val) === '')
		{
			$array->error($field, 'filename_empty', array($val));
		}
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
		return $query === NULL ? $this : $this->where(
			DB::expr('MATCH(asset.description, asset.filename)'), 
			'', 
			DB::expr('AGAINST(' . Database::instance()->escape($query) . ')')
		);	
	}
		
	public function __get($key) {
		
		if (($key == 'width' OR $key == 'height') AND $this->is_image())
		{
			try
			{
				$image_size = getimagesize($this->path(TRUE));
				
				if ($image_size)
				{
					return ($key == 'width')
						? $image_size[0]
						: $image_size[1];
				}				
			}
			catch(Exception $e){}
		}
		
		return parent::__get($key);
	}
}
