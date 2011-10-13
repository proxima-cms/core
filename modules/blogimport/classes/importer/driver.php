<?php defined('SYSPATH') or die('No direct script access.');

abstract class Importer_Driver
{
	protected $config;

	abstract public function import_posts();
	abstract public function save_posts($posts);
	abstract public function save_post($data);
	abstract public function save_post_tags($tags);
	
	public function __construct($config = NULL)
	{
		$this->config = $config;
	}
}
