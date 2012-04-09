<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Asset size model
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Model_Asset_size extends Model_Base {

	public $_table_name = 'assets_sizes';

	protected $_belongs_to = array(
		'asset' => array('model' => 'asset', 'foreign_key' => 'asset_id'),
	);

	public function resize($path, $width = NULL, $height = NULL, $crop = NULL)
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::resize($file, $path, $width, $height, $crop);
		}
	}

	public function rotate($degrees = 90)
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::rotate($file, $degrees);
		}
	}

	public function sharpen($amount = 20)
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::rotate($file, $amount);
		}
	}

	public function flip_horizontal()
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::flip_horizontal($file);
		}
	}
	public function flip_vertical()
	{
		$file = $this->path(TRUE);

		if (file_exists($file))
		{
			Asset::flip_vertical($file);
		}
	}

	public function path($full = FALSE)
	{
		$path = Kohana::$config->load('assets.upload_path').'/resized/'.$this->filename;

		return ($full)
			   ? DOCROOT.$path
			   : $path;
	}

	public function admin_delete($id = NULL, & $data)
	{
		return parent::delete($id);
	}
}
