<?php defined('SYSPATH') or die('No direct script access.');

class Model_Tag extends Model_Base { 
	
	protected $_belongs_to = array(
		'user' => array('model' => 'user', 'foreign_key' => 'user_id'),
	);	
	
	protected $_has_many = array(
		//'sizes' => array('model' => 'asset_size', 'foreign_key' => 'asset_id'),
	);	

	protected $_rules = array(
    'name' => array(
      array('not_empty'),
      array('min_length', array(':value', 4)),
      array('max_length', array(':value', 32)),
    ),  
	);	
	
	// Validation callbacks
	protected $_callbacks = array(
		'upload' => array(
			'extension' => array('callback_mimetype_exists'),
		),	
		'update' => array(
			'filename' => array('callback_filename_empty'),
		),	
	);	

  public function admin_add(& $data)
  {
    $data = Validation::factory($data);

    $fields = array(
      'name'
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
    $this->user_id = 0;
    $this->save();

    return $data;
  }
	
} // End Model_Tag
