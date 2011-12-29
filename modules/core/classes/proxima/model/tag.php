<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Tag extends Model_Base { 
	
	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 32)),
			), 
			'slug' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 32)),
			),
		);
	}	

	public function admin_add($data)
	{
		$this->values($data);
		$this->user_id = Auth::instance()->get_user()->id;
		$this->save();

		return $data;
	}

	public function admin_update($data)
	{
		$this->values($data);
		$this->save();

		return $data;
	}

	public function admin_delete()
	{
		return parent::delete();
	}
	
} // End Model_Tag
