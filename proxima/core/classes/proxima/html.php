<?php defined('SYSPATH') or die('No direct script access.');

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
