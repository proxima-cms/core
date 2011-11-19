<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
return array(
	'core'        => MODPATH.'core',       // Core Proxima module
	'pages'       => MODPATH.'pages',      // Pages module
	'admin'       => MODPATH.'admin',      // Admin module
	'assets'      => MODPATH.'assets',     // Asset manager module
	'users'       => MODPATH.'users',      // Users module
	'tags'        => MODPATH.'tags',       // Tags module
	'site'        => MODPATH.'site',       // Public site module
	'image'       => MODPATH.'image',      // Image manipulation
	'pagination'  => MODPATH.'pagination', // Pagination module
	'compress'    => MODPATH.'compress',   // Assets compressor module
	'minion'      => MODPATH.'minion',     // CLI module
	'cache'       => MODPATH.'cache',      // Caching with multiple backends
	'auth'        => MODPATH.'auth',       // Basic authentication
	'database'    => MODPATH.'database',   // Database access
	'orm'         => MODPATH.'orm',        // Object Relationship Mapping
	'message'     => MODPATH.'message',    // Session message module
	'blogimport'  => MODPATH.'blogimport', // Blog importer module
	'redirects'   => MODPATH.'redirects',  // Redirects module

	// 'codebench'  => MODPATH.'codebench',  // Benchmarking tool
	// 'unittest'   => MODPATH.'unittest',   // Unit testing
	// 'userguide'  => MODPATH.'userguide',  // User guide and API documentation
);
