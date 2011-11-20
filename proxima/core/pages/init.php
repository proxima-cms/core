<?php defined('SYSPATH') or die('No direct script access.');

Route::set('admin/pages-types', 'admin/pages/types(/<action>)(/<id>)')
  ->defaults(array(
    'controller'  => 'pages_types',
    'directory'   => 'admin',
  )); 
