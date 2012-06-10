<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Form helper class, which extends the default kohana form.
 * New features include: managing form errors and error states on fields
 * and labels.
 *
 * @package		 Proxima CMS
 * @category	 Core
 * @author		 Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license		 https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Form extends Kohana_Form {

	private static function attributes($name,&$attributes = NULL, $errors = NULL, $error_cls = 'error-field')
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
				$attributes['class'] = trim( (string) @$attributes['class'].' '.$error_cls);
			}
		}
	}

	public static function error_css($name, $errors = array(), $cls = 'error')
	{
		if (!$errors)
		{
			return '';
		}
		// Merge in external validation errors.
		$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()));

		if (isset($errors[$name]))
		{
			return ' '.$cls;
		}

		return '';
	}

	public static function control_group($options = array(), $errors = array(), $view = 'admin/page/fragments/form_control')
	{
		$options = $options + array(
			'label' => '',          // Field label
			'name' => '',           // Field name
			'type' => 'input',      // Field type
			'options' => array(),   // Select field options
			'value' => '',          // Field value
			'class' => NULL,        // Field css class name
			'help-block' => NULL    // Field help-block content
		);

		$field_options = array($options['name']);
		if ($options['type'] === 'select')
		{
			$field_options[] = $options['options'];
		}
		$field_options[] = $options['value'];
		$field_options[] = array('class' => $options['class']);

		$field = call_user_func_array('Form::' . $options['type'], $field_options);

		return View::factory($view, array(
			'field' => $field,
			'has_error' => isset($errors[$options['name']]),
			'options' => $options,
			'errors' => $errors
		));
	}

	public static function error_msg($name, $errors, $view = 'messages/field_error')
	{
		if ($errors !== NULL)
		{
			// Merge in external validation errors.
			$errors = array_merge($errors, (isset($errors['_external']) ? $errors['_external'] : array()));

			// Use the label_error view to append an error message to the label
			if (isset($errors[$name]))
			{
				return View::factory($view)->bind('error', $errors[$name]);
			}
		}

		return '';
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

	public static function label($input, $text = NULL, array $attributes = NULL, array $errors = NULL)
	{
		return parent::label($input, $text, $attributes);
	}

} // End Base_Form
