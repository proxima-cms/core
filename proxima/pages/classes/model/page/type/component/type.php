<?php defined('SYSPATH') or die('No direct script access.');

class Model_Page_Type_Component_Type extends Model_Base
{ 
	
	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 128)),
			),  
		);  
	}

	
} // End Model_Page_Type
