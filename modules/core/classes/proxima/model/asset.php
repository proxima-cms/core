<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Asset extends Model_Base_Asset {
	
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

				$this->admin_add_uploaded($data);
			}	
		}
		else
		{
			throw new Exception(__('No files were uploaded.'));
		}
	}

	public function admin_add_uploaded($data = array())
	{
		$file_path   = $data['file_path'];
		$file_name   = basename($file_path);
		$extension   = Asset::extension($file_name);
		$description = preg_replace('/\.\w+$/', '', $file_name);		// remove extension
		$description = preg_replace('/[_-]/', ' ', $description);		// replace special chars

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
