<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin logs controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Logs extends Controller_Admin_Base {

	public function action_index()
	{
		$file = $this->request->param('file');

		$this->template
			->title(__('Admin - Logs'))
			->content(
				View_Model::factory('admin/page/logs/index')
					->set('filename', $file)
			);
	}

	public function action_download()
	{
		$format = $this->request->param('format');

		if ($format === 'tar')
		{
			$dir = APPPATH . 'logs';

			$time = time();

			// Build the filename
			$file = "/tmp/{$time}/site-logs.{$time}.tar.gz";

			// Generate an archive of the logs directory
			`mkdir -p /tmp/{$time} && cp -r {$dir} /tmp/{$time} && cd /tmp/{$time} && tar cfvz {$file} logs`;

			// Send the file for download and delete from filesystem
			$this->response->send_file($file, NULL, array('delete' => TRUE));
		}
		else
		{
			throw new Request_Exception('Unsupported download archive format.');
		}
	}

}
