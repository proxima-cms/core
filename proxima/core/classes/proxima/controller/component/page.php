<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Site component page controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Component_Page extends Controller_Component {

	public function action_nav()
	{
		// Merge in the default request data
		$data = array_merge(array('parent_id' => 1), $this->request->query());

		$this->template->content = View_Model::factory('components/page/nav/nav', $data);
	}
}
