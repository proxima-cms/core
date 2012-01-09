<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Component {

	public static function factory($name=NULL, $config=array())
	{
		$component = 'Component_Driver_'.ucfirst($name);

		return new $component($config);
	}
}
