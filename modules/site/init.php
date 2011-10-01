<?php defined('SYSPATH') or die('No direct script access.');
Route::set('site', '(<url>)')
  ->defaults(array(
    'controller'  => 'site',
		'action' => 'index'
  ));
