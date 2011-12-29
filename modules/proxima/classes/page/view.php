<?php defined('SYSPATH') or die('No direct access allowed.');

/**
 * Page View library. Singleton abstracted view-model
 */
class Page_View {

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
				throw new HTTP_Exception_404('Not found.');
			}

			static::$_instance = View_Model::factory($data['view_model']);
		}


		return static::$_instance;
	}

} // End Page_View
