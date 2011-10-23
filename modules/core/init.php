<?php defined('SYSPATH') or die('No direct script access.');

// Attach the database config reader.
Kohana::$config->attach(new Config_Database);
