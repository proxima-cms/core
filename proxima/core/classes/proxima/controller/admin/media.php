<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin media controller
 *   - Serves admin media files
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Media extends Controller_Admin_Base {

	public $auto_render = FALSE;

	public function action_index()
	{
		// Get the file path from the request
		$file = $this->request->param('file');

		$ext = trim(strrchr($file, '.'), '.');

		if ($file)
		{
			// Send the file content as the response
			$this->response->body(View::factory('admin/media/'.$file));
		}
		else
		{
			// Return a 404 Not Found status
			$this->response->status(404);
		}

		// Set the content type for this extension
		$this->response->headers('Content-Type', File::mime_by_ext($ext));
	}

} // End Controller_Admin_Media
