<?php defined('SYSPATH') or die('No direct script access.');

/*
 * This model represent a VIEW
 */

class Model_Site_Page extends Model_Base {

  protected $_belongs_to = array(
    'parent' => array('model' => 'site_page', 'foreign_key' => 'parent_id'),
    'pagetype'  => array('model' => 'pagetype'),
  );  
  
  protected $_has_many = array(
    'children'  => array('model' => 'site_page', 'foreign_key' => 'parent_id'),
    'tags'      => array('model' => 'tag', 'through' => 'tags_pages', 'foreign_key' => 'page_id'),
  ); 
	
} // End Model_Site_Page
