<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Site component tag controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Component_Tag extends Controller_Component {

	public function action_list()
	{
		$this->template->content = View_Model::factory('components/tags/taglist/tags');
	}
}
