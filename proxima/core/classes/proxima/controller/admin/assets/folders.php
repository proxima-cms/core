<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Assets_Folders extends Controller_Admin_Base {
	
	public function action_index()
	{
		$request_data = array('request' => $this->request->query());  

		$this->template
			->title(__('Admin - Assets - Folders'))
			->content(
				View_Model::factory('admin/page/assets/folders/index', $request_data)
			);  
	}
	
	public function action_add()	
	{
		$request_data = array('request' => $this->request->query());

		$this->template
			->title(__('Admin - Assets - Add folder'))
			->content(
				View_Model::factory('admin/page/assets/folders/add', $request_data)
				->bind('folder', $folder)
				->bind('errors', $errors)
				);
		
		$folder = ORM::factory('asset_folder');

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$folder->admin_add($this->request->post());

				Message::set(Message::SUCCESS, __('Folder successfully added.'));			

				$this->request->redirect( $this->request->post('return_to') ?: 'admin/assets/folders' );
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/assets/folders');

				Message::set(MESSAGE::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_edit()	
	{
		$folder = ORM::factory('asset_folder', $this->request->param('id'));

		if (!$folder->loaded())
		{
			throw new Exception('Folder not found');
		}

		$request_data = array('request' => $this->request->query());

		$this->template
			->title(__('Admin - Assets - Edit folder'))
			->content(
				View_Model::factory('admin/page/assets/folders/edit', $request_data)
				->set('folder', $folder)
				->bind('errors', $errors)
			); 

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$folder->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __('Folder successfully updated.'));			

				$this->request->redirect($this->request->uri());
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/assets/folders');

				Message::set(MESSAGE::ERROR, __('Please correct the errors.'));
			}
		}
	}
}
