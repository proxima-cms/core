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
I18n::lang('en-gb');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (($env = getenv('KOHANA_ENV')) !== FALSE)
{
	Kohana::$environment = constant('Kohana::'.strtoupper($env));
}
else
{
	// Default to 'development' environment.
	Kohana::$environment = Kohana::DEVELOPMENT;
}

/**
 * Load the config
 */
Kohana::$config = new Config;

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Attach the environment specific configuration file reader to config if not in production.
 */
if (Kohana::$environment != Kohana::PRODUCTION)
{
	Kohana::$config->attach(new Config_File('config/environments/'.$env));
}

unset($env);

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
Kohana::init(Kohana::$config->load('init')->as_array());

/**
 * Attach a file reader to config. Multiple readers are supported.
 * Kohana::init will overwrite the config instance so we need to re-attach the reader/s.
 * This should be fixed in Kohana core!
 */
Kohana::$config->attach(new Config_File);

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Enable the modules.
 */
Kohana::modules(Kohana::$config->load('modules')->as_array());

/**
 * Initialize Proxima
 */
Core::init();
