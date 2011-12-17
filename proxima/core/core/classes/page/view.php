<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Page View library. Singleton abstracted view-model
 *
 */
class Page_View {

	// Page_View instances
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
				throw new Exception('A page view model needs to be specified.');
			}

			static::$_instance = View_Model::factory($data['view_model']);
		}

		return static::$_instance;
	}

} // End Page_View
