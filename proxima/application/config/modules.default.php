<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */

return Core::enabled_modules();

/*
return array(
	'core'        => CORPATH.'core',       // Core module
	'pages'       => CORPATH.'pages',      // Pages module
	'admin'       => CORPATH.'admin',      // Admin module
	'assets'      => CORPATH.'assets',     // Asset manager module
	'users'       => CORPATH.'users',      // Users module
	'tags'        => CORPATH.'tags',       // Tags module
	'site'        => CORPATH.'site',       // Public site module
	'image'       => CORPATH.'image',      // Image manipulation
	'pagination'  => CORPATH.'pagination', // Pagination module
	'compress'    => CORPATH.'compress',   // Assets compressor module
	'minion'      => CORPATH.'minion',     // CLI module
	'cache'       => CORPATH.'cache',      // Caching with multiple backends
	'auth'        => CORPATH.'auth',       // Basic authentication
	'database'    => CORPATH.'database',   // Database access
	'orm'         => CORPATH.'orm',        // Object Relationship Mapping
	'message'     => CORPATH.'message',    // Session message module
	'blogimport'  => CORPATH.'blogimport', // Blog importer module
	'redirects'   => CORPATH.'redirects',  // Redirects module
);
*/
