<?php defined('SYSPATH') or die('No direct script access.');

class Importer_Driver
{
	protected $config;
	
	public function __construct($config = NULL)
	{
		$this->config = $config;
	}
}
