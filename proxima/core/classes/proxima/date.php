<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Date helper class
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
abstract class Proxima_Date extends Kohana_Date {

	public static function friendly($date = NULL)
	{
		$time = strtotime($date);

		// If not less than 5 min then return formatted date, else return fuzzy span date.
		if (time() - $time > (60 * 5))
		{
			return date(Kohana::$config->load('listing.date_format'), $time);
		}
		else
		{
			return Date::fuzzy_span($time);
		}
	}
}
