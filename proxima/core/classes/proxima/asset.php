<?php defined('SYSPATH') or die('No direct script access.');
/**
 * File asset helper class
 *
 * @package    Proxima CMS
 * @category   Core
 * @author     Proxima CMS Team
 * @copyright  (c) 2011-2012 Proxima CMS Team
 * @license    https://raw.github.com/proxima-cms/core/master/LICENSE.md
 */
class Proxima_Asset {

	public static function add($file_path = NULL)
	{
		if (!Valid::url($file_path) AND !file_exists($file_path))
		{
			throw new Exception('File does not exist on file system.');
		}

		// Does the asset exist on the server?
		if (Valid::url($file_path) === TRUE)
		{
			try
			{
				// Download the file
				$asset_data = Request::factory($file_path)
					->method(Request::GET)
					->execute();
			}
			catch(Request_Exception $e)
			{
				throw $e;
			}

			$file_path = DOCROOT
				. Kohana::$config->load('assets.upload_path')
				. DIRECTORY_SEPARATOR
				. basename($file_path);

			file_put_contents($file_path, $asset_data);
		}

		$asset = ORM::factory('asset');

		$asset->admin_add($file_path);

		return $asset;
	}

	public static function resize($file_in = NULL, $file_out = NULL, $width = NULL, $height = NULL, $crop = NULL)
	{
		if ($width !== NULL AND $height !== NULL)
		{
			$image = Image::factory($file_in);

			if ($crop !== NULL)
			{
				if (($image->width / $image->height) > ($width / $height))
				{
					$resized_w = ($height / $image->height) * $image->width;
					$offset_x  = round(($resized_w - $width) / 2);
					$offset_y  = 0;
					$image->resize(NULL, $height);
				}
				else
				{
					$resized_h = ($width / $image->width) * $image->height;
					$offset_x  = 0;
					$offset_y  = round(($resized_h - $height) / 2);
					$image->resize($width, NULL);
				}

				$image->crop($width, $height, $offset_x, $offset_y);
			}
			else
			{
				$image->resize($width, $height);
			}

			$image->save($file_out);
		}
	}

	public static function docpath(Model_Asset $asset, $width = NULL, $height = NULL, $crop = NULL, $full_path = FALSE)
	{
		$pathinfo = pathinfo($asset->filename);

		$filename = $pathinfo['filename'];

		$crop = (string) (int) $crop;

		$path = Kohana::$config->load('assets.upload_path').'/'.$asset->filename;

		if ($asset->mimetype->subtype == 'image' AND $width AND $height)
		{
			
			$image = Image::factory($path);

			if ($image->height > $height OR $image->width > $width)
			{
				$filename = preg_replace('/^'.$asset->id.'_/', '', $filename);

				$filename = $asset->id."_{$width}_{$height}_{$crop}_{$filename}";

				$path = Kohana::$config->load('assets.upload_path').'/resized/'.$filename.'.'.$asset->mimetype->extension;
			}
		}
		elseif ($asset->mimetype->subtype == 'application' AND $asset->mimetype->type == 'pdf' AND $width AND $height)
		{
			$filename = preg_replace('/^'.$asset->id.'_/', '', $filename);

			$filename = $asset->id."_{$width}_{$height}_{$crop}_{$filename}";

			$path = Kohana::$config->load('assets.upload_path').'/resized/'.$filename.'.png';
		}

		if (!file_exists($path) AND $width !== NULL AND $height !== NULL)
		{
			// Find the size in the db
			$size = ORM::factory('asset_size')
				->where('asset_id', '=', $asset->id)
				->where('width', '=', $width)
				->where('height', '=', $height)
				->where('crop', '=', $crop)
				->find();

			// If no size then create one, this is a security feature
			// to disallow building image sizes anonymously.
			if (!$size->loaded())
			{
				$size->asset_id = $asset->id;
				$size->width = $width;
				$size->height = $height;
				$size->crop = $crop;
				$size->filename = basename($path);
				$size->save();
			}
		}

		return $path;
	}

	public static function image_url(Model_Asset $asset, $width = NULL, $height = NULL, $crop = NULL, $full_path = FALSE)
	{
		return URL::site(Route::get('media/assets/resized')
			->uri(array(
				'id'       => $asset->id,
				'width'    => $width,
				'height'   => $height,
				'crop'     => (string) (int) $crop,
				'filename' => $asset->friendly_filename
			)), $full_path);
	}

	public static function image_path(Model_Asset $asset, $width = NULL, $height = NULL, $crop = NULL, $full_path = FALSE)
	{
		$path = self::docpath($asset, $width, $height, $crop);

		return ($full_path) ? DOCROOT.$path : $path;
	}

	public static function path(Model_Asset $asset, $full = FALSE, $resized = '')
	{
		 $path = Kohana::$config->load('assets.upload_path').'/'.$resized.$asset->filename;

		 return ($full) ? DOCROOT.$path : $path;
	}

	public static function url(Model_Asset $asset, $full = FALSE)
	{
		return URL::site(Route::get('media/assets')
			->uri(array(
				'filename' => $asset->filename
			)), $full);
	}

	public static function rotate($file_in, $degrees)
	{
		Image::factory( $file_in )
		->rotate($degrees)
		->save();
	}

	public static function sharpen($file_in, $amount)
	{
		Image::factory( $file_in )
		->sharpen($amount)
		->save();
	}

	public static function flip_horizontal($file_in)
	{
		Image::factory( $file_in )
		->flip(Image::HORIZONTAL)
		->save();
	}

	public static function flip_vertical($file_in)
	{
		Image::factory( $file_in )
		->flip(Image::HORIZONTAL)
		->save();
	}

	public static function pdfthumb($file_in, $file_out, $width, $height, $crop)
	{
		exec('convert -quality 85 '.$file_in.'[0] '.$file_out);

		static::resize($file_out, $file_out, $width, $height, $crop);
	}

	public static function extension($file_name)
	{
		$pathinfo = pathinfo($file_name);

		return $pathinfo['extension'];
	}

	public static function description($file_name)
	{
		$description = preg_replace('/\.\w+$/', '', $file_name); // remove extension

		return preg_replace('/[_-]/', ' ', $description); // replace special chars
	}
}
