<?php defined('SYSPATH') or die('No direct script access.');

class Model_PageType extends Model_Base { 

	protected $_rules = array(
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
		),	
	);	

	public function admin_add(& $data)
	{
		$data = Validation::factory($data);

		$fields = array(
			'name',
			'description',
			'template'
		);	

		foreach($fields as $field) {
			$data->rules($field, $this->_rules[$field]);
		}		

		if (!$data->check())
		{		
			return FALSE;
		}		

		$this->values($data->as_array());
		#$this->user_id = Auth::instance()->get_user()->id;
		#$this->user_id = 0;
		$this->save();

		return $data;
	}

	public function admin_update(& $data)
	{
		$data = Validation::factory($data);

    $fields = array(
      'name',
      'description',
      'template'
    );  

    foreach($fields as $field) {
      $data->rules($field, $this->_rules[$field]);
    }   

    if (!$data->check())
    {   
      return FALSE;
    }   

		$this->values($data);
		$this->save();

		return $data;
	}

	public function admin_delete()
	{
		return parent::delete();
	}

	
} // End Model_PageType
