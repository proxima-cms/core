<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
return array(
	'core'				=> MODPATH.'core',
	'pages'				=> MODPATH.'pages',
	'admin'				=> MODPATH.'admin',
	'assets'			=> MODPATH.'assets',
	'users'				=> MODPATH.'users',
	'tags'				=> MODPATH.'tags',
	'site'				=> MODPATH.'site',
	'image'				=> MODPATH.'image',      // Image manipulation
	'pagination'	=> MODPATH.'pagination',
	'compress'		=> MODPATH.'compress',
	'cache'				=> MODPATH.'cache',      // Caching with multiple backends
	'auth'				=> MODPATH.'auth',       // Basic authentication
	'database'		=> MODPATH.'database',   // Database access
	'orm'					=> MODPATH.'orm',        // Object Relationship Mapping
	'message'			=> MODPATH.'message',
	'blogimport'	=> MODPATH.'blogimport',
	'redirects'		=> MODPATH.'redirects',
	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
);
