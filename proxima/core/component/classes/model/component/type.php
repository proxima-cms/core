<?php defined('SYSPATH') or die('No direct script access.');

class Model_Component_Type extends Model_Base {

	protected $_belongs_to = array(
		'user' => array('model' => 'user', 'foreign_key' => 'user_id'),
	);  

	protected $_has_many = array(
		'components'      => array('model' => 'component', 'foreign_key' => 'type_id'),
	); 
	
	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 128)),
			),  
			'description' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 255)),
			),  
		);  
	}

	public function admin_add($data)
	{
		$this->values($data);
		$this->user_id = Auth::instance()->get_user()->id;
		$this->save();

		return $this;
	}

	public function admin_update($data)
	{
		if (!$this->loaded())
		{
			throw new Exception('Component not found');
		}

		$this->values($data);
		$this->save();

		return $this;
	}

} // End Model_Component
