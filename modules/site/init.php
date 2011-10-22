<?php defined('SYSPATH') or die('No direct script access.');

/*
Route::set('default', '(<controller>(/<action>(/<id>)))')
->defaults(array(
'controller' => 'welcome',
'action' => 'index',
));
*/


Route::set('site', '<uri>', array('uri' => '.*'))
  ->defaults(array(
    'controller'  => 'site',
		'action' => 'index'
  ));
	
