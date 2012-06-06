<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin base controller
 *   - Sets the auth level
 *   - Sets the master view model
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Base extends Controller_Base {

	// Only users with role 'admin' can view this controller
	protected $_auth_required = 'admin';

	// Set the default admin master view model
	public $view_model = 'admin/page/master/page';

	public function before()
	{
		parent::before();

		$user = Auth::instance()->get_user();

		$this->template->set('username', $user ? $user->username : NULL);
	}
} // End Controller_Admin_Base
