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

		Modules::save_all();
	}

	public function admin_add_github_repo($data)
	{
		$validation = Validation::factory($data)
			->rule('github-name', 'not_empty')
			->rule('github-url', 'not_empty');

		if (! $validation->check())
		{
			throw new Validation_Exception($validation);
		}

		$url    = Arr::get($data, 'github-url');
		$name   = Arr::get($data, 'github-name');
		$folder = CORMODPATH.$name;

		$stderr = exec(sprintf('git clone %s %s 2>&1', escapeshellarg($url), escapeshellarg($folder)));

		// Git clone failed
		if (strpos(strtolower($stderr), 'error') !== FALSE OR strpos(strtolower($stderr), 'fatal') !== FALSE)
		{
			throw new Kohana_Exception($stderr);
		}

		// Update submodules
		$stderr = exec(sprintf('cd %s; git submodule update --init 2>&1', escapeshellarg($folder)));

		Modules::save_all();
	}
}
