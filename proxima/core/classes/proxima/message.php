<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Message extends Kohana_Message {

	public static function set($type, $text, array $options = NULL)
	{
		// Dont save the message in session if request is Ajax	
		if (!Request::current()->is_ajax()) {
			
			return parent::set($type, $text, $options);
		}
	}

}
