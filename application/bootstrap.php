<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/London');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'		=> '/',
	'index_file'	=> FALSE,
	'errors'      => TRUE,
	'caching'			=> Kohana::$environment !== Kohana::DEVELOPMENT
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);


/**
 * Custom application routes.
 */
Route::set('tag', 'tag(/<name>)')
	->defaults(array(
		'controller' => 'site',
		'action'     => 'index',
		'uri'        => 'tag'
	));

Route::set('error', 'error/<action>(/<message>)', array('action' => '[0-9]++', 'message' => '.+'))
	->defaults(array(
		'controller' => 'error'
	));

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
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
	));


if (!is_dir(DOCROOT . 'media'))
{
	throw new Kohana_Exception('Directory :dir does not exist',
		array(':dir' => Debug::path('media')));
}
if (!is_dir(DOCROOT . 'media/assets'))
{
	throw new Kohana_Exception('Directory :dir does not exist',
		array(':dir' => Debug::path('media/assets')));
}
if (!is_dir(DOCROOT . 'media/assets/resized'))
{
	throw new Kohana_Exception('Directory :dir does not exist',
		array(':dir' => Debug::path('media/assets/resized')));
}
if (!is_dir(DOCROOT . 'media/cache'))
{
	throw new Kohana_Exception('Directory :dir does not exist',
		array(':dir' => Debug::path('media/cache')));
}
if (! is_writable(DOCROOT . 'media/cache'))
{
	throw new Kohana_Exception('Directory :dir must be writable',
		array(':dir' => Debug::path('../media/cache')));
}
if (! is_writable(DOCROOT . 'media/assets/resized'))
{
	throw new Kohana_Exception('Directory :dir must be writable',
		array(':dir' => Debug::path('../media/assets/resized')));
}
