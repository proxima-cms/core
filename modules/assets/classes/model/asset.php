<?php defined('SYSPATH') or die('No direct script access.');

class Model_Asset extends Model_Base_Asset {
	
	public function admin_upload(& $file = array(), $field_name = 'asset')
	{

		$file_data = $file;
		$filename = strtolower($file[$field_name]['name']);

		$rules = $this->_rules;
		
		$rules['upload'][] = array('Upload::type', 
			array(':value', explode(',', Kohana::$config->load('admin/assets.allowed_upload_type')))
		);

		$file = Validation::factory($file);

    $validate_fields = array(
			'upload',
    );  

    foreach($validate_fields as $field)
		{
    	$file->rules($field_name, $rules[$field]);
    }   
		
		if (!$file->check())
		{	
			return $this;
		}

		try
		{
			$filepath = Upload::save($file_data[$field_name], $filename, DOCROOT.Kohana::$config->load('assets.upload_path'));
		}
		catch(Exception $e)
		{
			throw new Kohana_Exception($e);
		}

		$extension = Asset::extension($file[$field_name]['name']);
		$description = preg_replace('/\.\w+$/', '', $filename);		// remove extension
		$description = preg_replace('/[_-]/', ' ', $description);	// replace special chars

		$mimetype = ORM::factory('mimetype')
			->where('extension', '=', $extension)
			->find();

		// Save the file data
		$data = array(
			//'user_id' => Auth::instance()->get_user()->id,
			'mimetype_id' => $mimetype->id,
			'filename' => $filename,
			'friendly_filename' => $filename,
			'description' => $description,
			'filesize' => (int) $file_data[$field_name]['size']
		);		
		$this->values($data);
		$this->save();

		// Create a new filename with id prefixed
		$new_filename = str_replace($this->filename, $this->id.'_'.$this->filename, $filepath);
		$this->filename = basename($new_filename);
		$this->save();

		// Move the file to the new filename path
		rename($filepath, $new_filename);

		return $this;
	}
	
	public function admin_update(& $data)
	{
		$data = Validation::factory($data);

    $fields = array(
			'filename',
			'description',
    );  

    foreach($fields as $field)
		{
      $data->rules($field, $this->_rules[$field]);
    }   
		
		// Add validation callbacks			
		//foreach($this->_callbacks['update'] as $type => $callbacks)
		//{
		//	foreach($callbacks as $callback)
		//	{
		//		$data->callback('filename', array($this, $callback));
		//	}
	//	}
		
		if (!$data->check())
		{
			return FALSE;
		}

		$this->values($data->as_array());

		return $this->save();
	}
	
	public function admin_delete($id = NULL, $set_message = TRUE)
	{
		return parent::delete($id);		
	}
} // End Model_Asset
