<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin log helper class
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Admin_Log {

	// Returns a list of logs ordered by date in reverse
	public static function latest_entries()
	{
		// Recursively get a list of log files
		$logs = Kohana::list_files('logs');

		// Find the month directory name
		$log_year  = array_pop( $logs );
		$log_month = array_pop( $log_year );

		$entries = array();

		// Build an array of log entries
		foreach($log_month as $day => $path)
		{
			$path = str_replace(APPPATH.'logs/', '', $path);

			// Create array of log entries and merge it in
			$entries = array_merge($entries, static::get_entries($path));
		}

		return static::format_entries($entries);
	}

	public static function format_entries($entries = array())
	{
		$entries = array_reverse($entries);

		// Split the entry details into useful arrays
		foreach($entries as $key => $entry)
		{
			if (!strstr($entry, '---')) continue;

			list($date, $log) = explode('---', $entry);
			list($date, $time) = explode(' ', $date);
			list($year, $month, $day) = explode('-', $date);
			list($hour, $minute, $second) = explode(':', $time);

			$entries[$key] = array(
				'date'		=> trim($date),
				'log'		=> trim($log),
				'path'		=> "{$year}/{$month}/{$day}.php",
				'timestamp'	=> (string) mktime($hour, $minute, $second, $month, $day, $year)
			);
		}

		return $entries;
	}

	// Returns a list of log entries for a specified day ($file)
	public static function get_entries($file = NULL)
	{
		$entries = NULL;

		if ($file !== NULL)
		{
			// Strip extension from file name
			$file = preg_replace('/\..*?$/', '', $file);

			// Find the full path to the file
			$path = Kohana::find_file('logs', $file);

			if ($path !== FALSE)
			{
				// Get file contents
				$contents = trim(strip_tags(file_get_contents($path)));

				$entries = explode("\n", $contents);
			}
		}

		return $entries;
	}

	// Return a formatted array of log files (including directories)
	public static function get_directories_and_files()
	{
 		$logs = array();

		$files = static::get_logs();

		foreach($files as $logs_year => $logs_months)
		{
			$year = str_replace('logs/', '', $logs_year);

			$months = array();

			foreach($logs_months as $logs_month => $logs_day)
			{
				$month = (int) str_replace("logs/{$year}/", '', $logs_month);

				$month = date('F', mktime(0, 0, 0, $month, 1, date('Y')));

				$days = array();

				foreach($logs_day as $logs_log)
				{
					$days[] = $logs_log;
				}

				$months[$month] = $days;
			}

			$logs[$year] = $months;
		}

		return $logs;
	}

	// Return a formatted array of log files (excluding log directories)
	public static function get_log_files()
	{
		$files = array();

		$logs = Kohana::list_files('logs');

		foreach($logs as $year => $months)
		{
			foreach($months as $month => $day)
			{
				foreach($day as $log)
				{
					$files[] = $log;
				}
			}
		}

		return $files;
	}

	// Return an array of all log directories and files
	public static function get_logs()
	{
		return Kohana::list_files('logs');
	}

} // End Admin_Log
