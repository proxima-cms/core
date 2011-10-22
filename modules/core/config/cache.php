<?php defined('SYSPATH') or die('No direct script access.');

return array(
  'file'    => array(
    'driver'             => 'file',
    'cache_dir'          => APPPATH.'cache',
    'default_expire'     => 365 * 24 * 60 * 60,
    'ignore_on_delete'   => array(
      '.gitignore',
      '.git',
      '.svn'
    )
  ),	
	'apc'      => array
	(
		'driver'					=> 'apc',
		'default_expire'	=> 3600
	)
);
