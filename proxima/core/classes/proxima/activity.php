<?php defined('SYSPATH') or die('No direct script access.');
/**
 * User activity class
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Activity {

	// Notification types
	const SUCCESS = 'success';
	const NOTICE  = 'notice';
	const ERROR   = 'error';

	public static function set($type, $text = "")
	{
		$activity = ORM::factory('activity');
		$activity->user_id = (int) Auth::instance()->get_user()->id;
		$activity->type = $type;
		$activity->text = $text;
		$activity->request_data = serialize(@$_REQUEST);
		$activity->uri = Request::instance()->uri;
		$activity->save();
	}
}
