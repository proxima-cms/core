<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Site error page controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Error extends Controller_Base {

	public function before()
	{
		$this->template = 'themes/badsyntax/templates/error';

		parent::before();

		$this->template->page = URL::site(rawurldecode(Request::$initial->uri()));

		// Internal request only!
		if (Request::$initial !== Request::$current)
		{
			if ($message = rawurldecode($this->request->param('message')))
			{
				$this->template->message = $message;
			}
		}
		else
		{
			$this->request->action(404);
		}

		$this->response->status((int) $this->request->action());
	}

	public function action_404()
	{
		$this->template->title = '404 Not Found';

		// Here we check to see if a 404 came from our website. This allows the
		// webmaster to find broken links and update them in a shorter amount of time.
		if (isset ($_SERVER['HTTP_REFERER']) AND strstr($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']) !== FALSE)
		{
			// Set a local flag so we can display different messages in our template.
			$this->template->local = TRUE;
		}

		// HTTP Status code.
		$this->response->status(404);
	}

	public function action_503()
	{
		$this->template->title = 'Maintenance Mode';
	}

	public function action_500()
	{
		$this->template->title = 'Internal Server Error';
	}
}
