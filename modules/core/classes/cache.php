<?php defined('SYSPATH') or die('No direct script access.');

abstract class Cache Extends Kohana_Cache {

	/**
	 * @var   string     default driver to use
	 */
	public static $default = 'apc';

}
