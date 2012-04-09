<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form helper class, which extends the default kohana form.
 * New features include: managing form errors and error states on fields
 * and labels.
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Form extends Kohana_Form {

	private static function attributes($name, & $attributes = NULL, $errors = NULL)
	{
		// Set the id attribute
		if (!isset($attributes['id']))
		{
			$attributes['id'] = $name;
		}

		if ($errors !== NULL)
		{
			// Merge in external validation errors.
			$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()));

			// Set the error classname
			if (isset($errors[$name]))
			{
				$attributes['class'] = trim( (string) @$attributes['class'].' error-field');
			}
		}
	}

	public static function input($name, $value = NULL, array $attributes = NULL, array $errors = NULL)
	{
		static::attributes($name, $attributes, $errors);

		return parent::input($name, $value, $attributes);
	}

	public static function select($name, array $options = NULL, $selected = NULL, array $attributes = NULL, array $errors = NULL)
	{
		static::attributes($name, $attributes, $errors);

		return parent::select($name, $options, $selected, $attributes);
	}

	public static function password($name, $value = NULL, array $attributes = NULL, array $errors = NULL)
	{
		static::attributes($name, $attributes, $errors);

		return parent::password($name, $value, $attributes);
	}

	public static function textarea($name, $body = '', array $attributes = NULL, $double_encode = TRUE, array $errors = NULL)
	{
		static::attributes($name, $attributes, $errors);

		return parent::textarea($name, $body, $attributes, $double_encode);
	}

	public static function file($name, array $attributes = NULL, array $errors = NULL)
 	{
		static::attributes($name, $attributes, $errors);

		return parent::file($name, $attributes);
	}

	public static function label($input, $text = NULL, array $attributes = NULL, array $errors = NULL, $view = 'messages/label_error')
	{
		if ($errors !== NULL)
		{
			// Merge in external validation errors.
			$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()));

			// Use the label_error view to append an error message to the label
			if (isset($errors[$input]))
			{
				$text .= View::factory($view)->bind('error', $errors[$input]);
			}
		}

		return parent::label($input, $text, $attributes);
	}

} // End Base_Form
