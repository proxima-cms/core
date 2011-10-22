<?php defined('SYSPATH') or die('No direct script access.');

class Model_Redirect extends Model_Base {

	public function rules()
	{
		return array(
			'uri' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 255)),
				//array('url'),
			),
			'target' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 64)),
			),
			'target_id' => array(
				array('not_empty'),
				array('numeric'),
			)
		);
	}

	public function admin_add(& $data)
	{
		$data = Validation::factory($data);
		$rules = $this->rules();

		$fields = array(
			'uri',
			'target',
			'target_id',
		);	
		foreach($fields as $field)
		{		
			$data->rules($field, $rules[$field]);
		}		

		if (!$data->check())
		{		
			return FALSE;
		}		

		$post = $data->as_array();
		$this->values($post);

		return $this->save();
	}

	public function admin_update(& $data)
	{
		$data = Validation::factory($data);
		$rules = $this->rules();

		$fields = array(
			'uri',
			'target',
			'target_id',
		);	
		foreach($fields as $field)
		{		
			$data->rules($field, $rules[$field]);
		}		
		
		if ( !$data->check())
		{		
			return FALSE;
		}		

		$data = $data->as_array();

		$this->values($data);

		return $this->save();
	}

	public function admin_delete()
	{
		return parent::delete();
	}
} // End Model_Redirect
