<?php defined('SYSPATH') or die('No direct access allowed.');

abstract class Component_Component {

	protected $_config = array();

	protected $_default_config = array();

	abstract public function render();

	public function __construct($config=array())
	{
		$this->_config = array_merge($this->_default_config, $config);
	}
}
