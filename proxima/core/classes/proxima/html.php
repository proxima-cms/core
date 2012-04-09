<?php defined('SYSPATH') or die('No direct script access.');
/**
 * HTML helper class, which extends the default Kohana HTML class.
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
abstract class Proxima_HTML extends Kohana_HTML {

	public static function styles($styles)
	{
		return implode("\n", array_map('HTML::style', $styles));
	}

	public static function scripts($scripts)
	{
		return implode("\n", array_map('HTML::script', $scripts));
	}

}
