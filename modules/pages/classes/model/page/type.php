<?php defined('SYSPATH') or die('No direct script access.');

class Model_Page_Type extends Model_Base
{ 
	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 32)),
			),	
			'description' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 255)),
			),	
			'template' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 32)),
			)	
		);
	}

	public function filters()
	{
		return array(
			// As the 'controller' field may be NULL in the DB, 
			// we need to ensure a PHP NULL value if empty string,
			'controller' => array(
				array(function($value){
					return ($value === '') ? NULL : $value;
				}, array(':value')),
			)
		);
	}

	public function admin_add($data)
	{
		$this->values($data);

		return $this->save();
	}

	public function admin_update($data)
	{
		$this->values($data);

		return $this->save();
	}

	public function admin_delete()
	{
		return parent::delete();
	}
	
} // End Model_Page_Type
