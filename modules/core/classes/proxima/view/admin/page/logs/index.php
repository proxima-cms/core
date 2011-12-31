<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Admin_Page_Logs_Index extends View_Model_Admin {

	// Return an array of directions and files
	public function var_directories_and_files()
	{
		$logs = Admin_Log::get_directories_and_files();

		$html = View::factory('admin/page/logs/filelist/open');

		foreach($logs as $year => $months)
		{
			$html .= View::factory('admin/page/logs/filelist/year_open', array(
				'cur_year' => NULL,
				'year'     => $year
			));

			foreach($months as $month => $day)
			{
				$html .= View::factory('admin/page/logs/filelist/month_open', array(
					'cur_month' => NULL,
					'month'     => $month
				));

				foreach($day as $log)
				{
					$html .= View::factory('admin/page/logs/filelist/day', array(
						'log'      => $log,
						'log_name' => preg_replace('/.*?(\d+)'.EXT.'$/', '$1', $log),
						'month'    => $month,
						'year'     => $year
					));
				}

				$html .= View::factory('admin/page/logs/filelist/month_close');
			}

			$html .= View::factory('admin/page/logs/filelist/year_close');
		}

		$html .= View::factory('admin/page/logs/filelist/close');

		return $html;
	}

	// Returns an array of all log files
	public function var_files()
	{
		return Admin_Log::get_log_files();
	}

	public function var_entries()
	{
		$entries = Admin_Log::get_entries($this->filename);

		if ($entries !== NULL)
		{
			$entries = Admin_Log::format_entries($entries);
		}

		return $entries;
	}

	public function var_total_files()
	{
		return count($this->files);
	}

}
