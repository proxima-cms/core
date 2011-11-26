<?php defined('SYSPATH') or die('No direct script access.');

class View_Model extends View {

	public static function factory($file = NULL, array $data = NULL)
	{
		$viewclass = str_replace('/', '_', "view/{$file}");

		return new $viewclass($file, $data);
	}

	public function render($file = NULL)
	{
		foreach(get_class_methods($this) as $method)
		{
			if (preg_match("/^var_/", $method))
			{
				$var_method = preg_replace("/^var_/", '', $method);

				$this->set($var_method, $this->{$method}());
			}
		}

		return parent::render($file);
	}
}
