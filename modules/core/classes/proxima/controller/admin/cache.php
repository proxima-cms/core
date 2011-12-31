<?php defined('SYSPATH') or die('No direct script access.');

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

		Message::set(Message::SUCCESS, __('Cache successfully deleted.'));

		$this->request->redirect('admin/cache');
	}

}
