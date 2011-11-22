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
		
			$this->admin_add($filepath);
		}
		catch(Exception $e)
		{
			throw new Kohana_Exception($e);
		}
	}

	public function admin_add($file_path)
	{
		$file_name = basename($file_path);

		$extension = Asset::extension($file_name);
		$description = preg_replace('/\.\w+$/', '', $file_name);		// remove extension
		$description = preg_replace('/[_-]/', ' ', $description);		// replace special chars

		$mimetype = ORM::factory('mimetype')
			->where('extension', '=', $extension)
			->find();

		$data = array(
			'user_id'						=> Auth::instance()->get_user()->id,
			'mimetype_id'				=> $mimetype->id,
			'filename'					=> $file_name,
			'friendly_filename' => $file_name,
			'description'				=> $description,
			'filesize'					=> filesize($file_path)
		);		
		$this->values($data);
		$this->save();

		// Create a new filename with id prefixed
		$new_filename = str_replace($this->filename, $this->id.'_'.$this->filename, $file_path);
		$this->filename = basename($new_filename);
		$this->save();

		// Move the file to the new filename path
		rename($file_path, $new_filename);
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
			}

			$resized->delete();
		}
	
		return parent::delete();		
	}
} // End Model_Asset
