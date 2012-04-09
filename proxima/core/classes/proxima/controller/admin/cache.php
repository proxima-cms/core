<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin cache controller
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Cache extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template
			->title( __('Admin - Cache') )
			->content( View_Model::factory('admin/page/cache/index') );
	}

	public function action_purge()
	{
		Cache::instance()->delete_all();

		$media_files = Kohana::list_files(NULL, array(DOCROOT.'media/cache'));

		foreach($media_files as $file)
		{
			try
			{
				unlink($file);
			}
			catch(Exception $e)
			{
				die('unable to delete file');
			}
		}

		Message::set(Message::SUCCESS, __('Cache successfully deleted.'));

		$this->request->redirect('admin/cache');
	}

}
