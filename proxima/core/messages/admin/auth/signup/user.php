<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'email' => array(
		'unique' => 'email address is already registered',
	),
	'username' => array(
		'unique' => 'username is already registered',
	),
	'_external' => array(
		'password_confirm' => array(
			'matches' => 'password confirm must match password'
	)
);
