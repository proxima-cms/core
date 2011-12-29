<?php defined('SYSPATH') or die('No direct script access.');

class Model_Component extends Model_Base {

	protected $_belongs_to = array(
		'user' => array('model' => 'user', 'foreign_key' => 'user_id'),
	);  
	
	public function rules()
	{
		return array(
			'data' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
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
