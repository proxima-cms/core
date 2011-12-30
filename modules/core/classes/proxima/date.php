<?php defined('SYSPATH') or die('No direct script access.');

abstract class Proxima_Date extends Kohana_Date {

	public static function friendly($date = NULL)
	{
		$time = strtotime($date);

		$date_format = Kohana::$config->load('listing.date_format');

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
