<?php defined('SYSPATH') or die('No direct access allowed.');
/**
 * Component class
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
abstract class Proxima_Component_Component {

	protected $_config = array();

	protected $_default_config = array();

	abstract public function render();

	public function __construct($config=array())
	{
		$this->_config = array_merge($this->_default_config, $config);
	}

	// Render the component when echoing out.
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

	// Config getter.
	public function config($key = NULL)
	{
		return $this->_config[$key];
	}
}
