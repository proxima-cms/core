<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Message helper class, which extends from the Message module
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Message extends Kohana_Message {

	public static function set($type, $text, array $options = NULL)
	{
		// Dont save the message in session if request is Ajax
		if (!Request::current()->is_ajax()) {

			return parent::set($type, $text, $options);
		}
	}

}
