<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Admin assets controller (asset manager)
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Controller_Admin_Assets extends Controller_Admin_Base {

	public function action_index($view = 'admin/page/assets/index')
	{
		$data = array(
			'search'  => $this->request->post('search'),
			'request' => $this->request->query()
		);

		$this->template
			->title(__('Admin - Assets'))
			->content(
				View_Model::factory($view, $data)
			);
	}

	public function action_upload($view = 'admin/page/assets/upload', $redirect_to = 'admin/assets')
	{
		$this->template
			->title(__('Admin - Upload assets'))
			->content(
				View_Model::factory($view)
				->bind('errors', $errors)
			);

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$uploaded = ORM::factory('asset')->admin_upload($_FILES, $this->request->post());
			}
			// Error validating the uploaded files.
			catch(Validation_Exception $e)
			{
				$errors = $e->array->errors('admin/assets');
			}
			// Error processing the uploaded files.
			catch(Exception $e)
			{
				throw $e;
			}
			// Error saving the file data to the db.
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/assets');
			}

			if ($errors === NULL)
			{
				$message = ($uploaded > 1)
					? __(':assets_count assets successfully uploaded.')
					: __(':assets_count asset successfully uploaded.');

				Message::set(Message::SUCCESS, __($message, array(':assets_count' => $uploaded)));

				$this->request->redirect($redirect_to);
			}
			else
			{
				$message = __('Error uploading files.');

				Message::set(Message::ERROR, __($message, array(':errors_count' => count($errors))));
			}
		}
	}

	public function action_edit()
	{
		$asset = ORM::factory('asset', $this->request->param('id'));

		if (!$asset->loaded())
		{
			throw new Exception('Asset not found');
		}

		$request_data = array('request' => $this->request->query());

		$this->template
			->title(__('Admin - Edit asset'))
			->content(
				View_Model::factory('admin/page/assets/edit', $request_data)
				->set('asset', $asset)
				->bind('errors', $errors)
			);

		if ($this->request->method() === Request::POST)
		{
			try
			{
				$asset->admin_update($this->request->post());

				Message::set(Message::SUCCESS, __('Asset successfully updated.'));

				$this->request->redirect($this->request->uri());
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('admin/assets');

				Message::set(MESSAGE::ERROR, __('Please correct the errors.'));
			}
		}
	}

	public function action_download()
	{
		$asset = ORM::factory('asset', $this->request->param('id'));

		if (!$asset->loaded())
		{
			exit;
		}

		$this->response->send_file($asset->path(TRUE), $asset->friendly_filename);
	}

	public function action_delete($id = NULL, $set_message = TRUE)
	{
		$assets = $this->request->param('id') ?: $this->request->query('assets');

		foreach($assets = explode(',', $assets) as $id)
		{
			$asset = ORM::factory('asset', $id);

			if (!$asset->loaded())
			{
				continue;
			}

			$asset->admin_delete();
		}

		Message::set(Message::SUCCESS, 'Asset successfully deleted.');

		$this->request->redirect('admin/assets');
	}

	public function action_get_asset()
	{
		$this->auto_render = FALSE;

		$id       = $this->request->param('id');
		$width    = $this->request->param('width');
		$height   = $this->request->param('height');
		$crop     = $this->request->param('crop');
		$filename = "{$id}_".$this->request->param('filename');
		$asset    = ORM::factory('asset', $id);

		if (!$asset->loaded() OR !file_exists($asset->image_path(NULL, NULL, NULL, TRUE)))
		{
			exit;
		}

		// Check the image size exists
		$size = ORM::factory('asset_size')
			->where('asset_id', '=', $asset->id)
			->where('width', '=', $width)
			->where('height', '=', $height)
			->where('crop', '=', $crop)
			->find();

		$path = $asset->image_path($width, $height, $crop, TRUE);

		if ($size->loaded() AND !file_exists($path))
		{
			$this->request->headers['Content-Type'] = $asset->mimetype->subtype.'/'.$asset->mimetype->type;

			if ($asset->mimetype->subtype === 'application' AND $asset->mimetype->type == 'pdf')
			{
				$file_in = DOCROOT.Kohana::$config->load('assets.upload_path').'/'.$asset->filename;

				// Generate an image thumbnail of the PDF
				Asset::pdfthumb($file_in, $path, $width, $height, $crop);
			}
			else
			{
				$asset->resize($path, $width, $height, $crop);
			}

			$size->filesize = filesize($path);
			$size->resized = 1;
			$size->save();

			$this->response->send_file($path, FALSE, array('inline' => true));
		}
	}

	public function action_get_url()
	{
		$id = $this->request->param('id');

		$this->auto_render = FALSE;

		$asset = ORM::factory('asset', (int) $id);

		if (!$asset->loaded())
		{
			exit;
		}

		$this->template->content($asset->url(TRUE));
	}

	public function action_get_image_url()
	{
		$id     = $this->request->param('id');
		$width  = $this->request->param('width');
		$height = $this->request->param('height');

		$this->auto_render = FALSE;

		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded() OR $asset->mimetype->subtype !== 'image')
		{
			exit;
		}

		$this->template->content($asset->image_url($width, $height, NULL, TRUE));
	}

	public function action_get_download_html()
	{
		$id = $this->request->param('id');

		$this->auto_render = FALSE;

		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded())
		{
			exit;
		}

		echo View::factory('admin/page/assets/popup/download_html')->set('asset', $asset);
	}

	public function action_rotate()
	{
		$id = $this->request->param('id');

		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded() OR $asset->mimetype->subtype !== 'image')
		{
			exit;
		}

		$asset->rotate(90);

		foreach($asset->sizes->find_all() as $asset_size)
		{
			$asset_size->rotate(90);
		}

		$this->request->redirect('admin/assets/edit/'.$asset->id);
	}

	public function action_sharpen()
	{
		$id = $this->request->param('id');

		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded() OR $asset->mimetype->subtype !== 'image')
		{
			exit;
		}

		$asset->sharpen(20);

		$this->request->redirect('admin/assets/edit/'.$asset->id);
	}

	public function action_flip_horizontal()
	{
		$id = $this->request->param('id');

		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded() OR $asset->mimetype->subtype !== 'image')
		{
			exit;
		}

		$asset->flip_horizontal();

		$this->request->redirect('admin/assets/edit/'.$asset->id);
	}

	public function action_flip_vertical()
	{
		$id = $this->request->param('id');

		$asset = ORM::factory('asset', $id);

		if (!$asset->loaded() OR $asset->mimetype->subtype !== 'image')
		{
			exit;
		}

		$asset->flip_vertical();

		$this->request->redirect('admin/assets/edit/'.$asset->id);
	}

} // End Controller_Admin_Assets
