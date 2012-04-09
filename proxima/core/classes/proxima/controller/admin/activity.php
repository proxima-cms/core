<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin activity controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Activity extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template->title = __('Admin - Activity');
		$this->template->content = View::factory('admin/page/activity/index')
			->bind('activities', $activities);

		$activities = ORM::factory('activity')
			->order_by('date', 'desc')
			->find_all();
	}

}
