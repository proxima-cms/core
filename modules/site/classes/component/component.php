<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Component_Component {

	protected $_config = array();

	protected $_default_config = array();

	abstract public function render();

	public function __construct($config=array())
	{
		$this->_config = array_merge($this->_default_config, $config);
	}

	public function __toString()
	{
		try 
		{		
			return $this->render();
		}		
		catch (Exception $e) 
		{		
			// Display the exception message
			Kohana_Exception::handler($e);

			return ''; 
		}		
	}
}
