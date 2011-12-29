<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Base_Group extends Model_Base {
	
	protected $_has_many = array(
		'users'    => array('through' => 'groups_users'), 
		'children' => array('model' => 'group', 'foreign_key' => 'parent_id')
	);	
	protected $_belongs_to = array(
		'parent' => array('model' => 'group', 'foreign_key' => 'parent_id'),
	);	
	
	public function rules()
	{
		return array(
		 'parent_id' => array(
				array('not_empty'),
			),  
			'name' => array(
				array('not_empty'),
				array('max_length', array(':value', array(255))),
			)
		);
	}
}
