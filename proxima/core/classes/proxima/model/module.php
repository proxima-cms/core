<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Module extends Model_Base {

	public function upload_rules($fieldname = 'module_file')
	{
		return array(
			"{$fieldname}" => array(
				array('Upload::not_empty', array(':value')),
				array('Upload::valid'),
				array('Upload::size', array(':value', '10M')),
				array('Upload::type', array(':value', array('zip','tar')))
			)
		);
	}

	public function admin_upload($data, $fieldname)
	{
		$validation = Validation::factory($data);

		foreach($this->upload_rules($fieldname) as $field => $rules)
		{
			$validation->rules($field, $rules);
		}

		if (! $validation->check())
		{
			throw new Validation_Exception($validation);
		}

		$file = $validation[$fieldname];
		$name = strtolower($file['name']);

		$path = CORMODPATH;

		$file_path = Upload::save($file, $name, $path);

		if ($file_path === FALSE)
		{
			throw new Exception(__('Unable to move the uploaded file.'));
		}

		$extension   = explode('.', $name);
		$extension   = strtolower(end($extension));
		$module_name = str_replace('.'.$extension, '', $name);
		$folder      = CORMODPATH . $module_name;

		switch($extension)
		{
			case 'zip':

				if (! (bool) exec("command -v unzip >/dev/null && { echo 1; } || { echo 0; }"))
				{
					throw new Kohana_Exception('The \'unzip\' program is not installed.');
				}

				$stderr = exec(sprintf('unzip %s -d %s 2>&1', escapeshellarg($file_path), escapeshellarg(CORMODPATH)));
			break;
			case 'tar':

				if (! (bool) exec("command -v tar >/dev/null && { echo 1; } || { echo 0; }"))
				{
					throw new Kohana_Exception('The \'tar\' program is not installed.');
				}

				$stderr = exec(sprintf('tar -xf %s %s 2>&1', escapeshellarg($file_path), escapeshellarg($folder)));
			break;
		}

		unlink($file_path);

		$config_file = implode(DIRECTORY_SEPARATOR, array($folder, 'config', $module_name, 'details' . EXT));

		if (! file_exists($config_file))
		{
			$stderr = exec(sprintf('rm -r %s 2>&1', escapeshellarg($folder)));

			throw new Kohana_Exception('Module details config file not found.');
		}

		Modules::save_all();
	}

} // End Model_Module
