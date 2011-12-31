<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Cache_Index extends View_Model_Admin {

	public function var_cache_dir()
	{
		return Kohana::$cache_dir;
	}

	public function var_total_size()
	{
		return Text::bytes( (int) `du -sb {$this->cache_dir} | sed 's/\s.*$//g'`);
	}

	public function var_total_files()
	{
		return `find {$this->cache_dir} -type f | wc -l`;
	}
}
