<?php defined('SYSPATH') or die('No direct script access.');

abstract class Proxima_HTML extends Kohana_HTML {

	public static function styles($styles = array())
	{
		if (!is_array($styles))
		{
			throw new Exception('Array expected');
		}

		$styles_html = '';

		foreach($styles as $style)
		{
			$styles_html .= HTML::style($style);
		}

		return $styles_html;
	}
	
	public static function scripts($scripts = array())
	{
		if (!is_array($scripts))
		{
			throw new Exception('Array expected');
		}

		$scripts_html = '';

		foreach($scripts as $script)
		{
			$scripts_html .= HTML::script($script);
		}

		return $scripts_html;
	}

}
