<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin assets popup controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Assets_Popup extends Controller_Admin_Assets {

	public $view_model = 'admin/page/assets/popup/master/page';

	public function before()
	{
		parent::before();

		//$this->template
		//	->scripts(array(Kohana::$config->load('admin/assets/popup.scripts')))
		//	->styles(array(Kohana::$config->load('admin/assets.styles')));
	}

	public function action_index($view = 'admin/page/assets/index')
	{
		parent::action_index('admin/page/assets/popup/index');

		//$this->template->scripts(array(Kohana::$config->load('admin/media.paths.tinymce_popup')));
	}

	public function action_upload($view_path = 'admin/page/assets/popup/upload', $redirect_to = 'admin/assets/popup#browse')
	{
		parent::action_upload($view_path, $redirect_to);
	}

	public function action_resize()
	{
		$asset = ORM::factory('asset', $this->request->param('id'));

		if (!$asset->loaded())
		{
			throw new Exception('Asset not found.');
		}

		$this->template
			->title(__('Resize Asset'))
			->content(
				View::factory('admin/page/assets/popup/resize')
				->set('asset', $asset)
			);
	}

	public function action_view()
	{
		$asset = ORM::factory('asset', $this->request->param('id'));

		if (!$asset->loaded())
		{
			throw new Exception('Asset not found.');
		}

		$this->template
			->title(__('View Asset'))
			->content(
				View_Model::factory('admin/page/assets/popup/view')
					->set('asset', $asset)
			);
	}

} // End Controller_Admin_Assets_Popup
