<?php defined('SYSPATH') or die('No direct script access.');


Route::set('admin/tag-delete', 'admin/tags/delete/<id>', array('id' => '.*'))
  ->defaults(array(
    'action'    => 'delete',
    'directory'   => 'admin',
    'controller'  => 'tags'
  )); 

