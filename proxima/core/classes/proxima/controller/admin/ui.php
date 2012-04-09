<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin UI controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_UI extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template->title = __('Admin - UI');
		$this->template->content = View::factory('admin/page/ui/index');
	}

} // End Controller_Admin_UI
