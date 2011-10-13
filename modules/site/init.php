<?php defined('SYSPATH') or die('No direct script access.');
Route::set('site', '<uri>', array('uri' => '.*'))
  ->defaults(array(
    'controller'  => 'site',
		'action' => 'index'
  ));
