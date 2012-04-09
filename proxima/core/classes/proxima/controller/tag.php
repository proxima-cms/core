<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Site tag controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Tag extends Controller_Page {

	public function action_index()
	{
		$tag_slug = Request::current()->param('param');

		if ($tag_slug === NULL)
		{
			$tag_slug = Request::current()->query('name');
		}

		$pages = Component::factory('Tag_Listing', array(
			'tag_slug'	=> $tag_slug
		))->render();

		$this->template->set_global('pages', $pages);
	}
}
