<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Mimetype extends Model_Base { 

	protected $_has_many = array(
		'assets' => array('model' => 'asset'), 
	);	
	
}
