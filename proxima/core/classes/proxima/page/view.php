<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Page View library. Singleton abstracted view-model
 */
class Proxima_Page_View {

	// Page_View view-model instance
	protected static $_instance;

	/**
	 * Singleton pattern
	 *
	 * @return Auth
	 */
	public static function instance($data = array())
	{
		if ( ! isset(static::$_instance))
		{

			if ( ! isset($data['view_model']))
			{
				throw new Kohana_Exception('View model template not set');
			}

			static::$_instance = View_Model::factory($data['view_model']);
		}


		return static::$_instance;
	}

} // End Page_View
