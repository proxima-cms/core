<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Model_Site_Page extends Model_Base {

	protected $_table = 'site_pages';

	protected $_belongs_to = array(
		'parent'      => array('model' => 'site_page', 'foreign_key' => 'parent_id'),
		'page_type'   => array('model' => 'page_type', 'foreign_key' => 'pagetype_id'),
	);

	protected $_has_many = array(
		'children'    => array('model' => 'site_page', 'foreign_key' => 'parent_id'),
		'component'   => array('model' => 'component', 'foreign_key' => 'page_id'),
	);

	protected $_table_columns = array(
		'id'                    => array('type' => 'int'),
		'user_id'               => array('type' => 'int'),
		'pagetype_id'           => array('type' => 'int'),
		'parent_id'             => array('type' => 'int'),
		'is_homepage'           => array('type' => 'int'),
		'visible_in_nav'        => array('type' => 'int'),
		'draft'                 => array('type' => 'int'),
		'title'                 => array('type' => 'string'),
		'uri'                   => array('type' => 'string'),
		'description'           => array('type' => 'string'),
		'body'                  => array('type' => 'string'),
		'visible_from'          => array('type' => 'string'),
		'visible_to'            => array('type' => 'string'),
		'date'                  => array('type' => 'string'),
		'pagetype_template'     => array('type' => 'string'),
		'pagetype_name'         => array('type' => 'string'),
		'pagetype_description'  => array('type' => 'string'),
		'user_email'            => array('type' => 'string'),
		'user_username'         => array('type' => 'string'),
		'tags'                  => array('type' => 'string'),
		);

} // End Model_Site_Page
