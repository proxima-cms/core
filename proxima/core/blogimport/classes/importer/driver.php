<?php defined('SYSPATH') or die('No direct script access.');

class Importer_Driver
{
	protected $config;
	
	/**  
	 * Constructs a new importer and sets the config.
	 *
	 * @param		mixed $config The driver config
	 * @return	void
	 */
	public function __construct($config = NULL)
	{
		$this->config = $config;
	}
}
