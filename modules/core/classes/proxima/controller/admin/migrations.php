<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_Controller_Admin_Migrations extends Controller_Admin_Base {

	public function action_index()
	{
		$this->template->title = __('Admin - Migrations');
		$this->template->content = View::factory('admin/page/migrations/index');
	}
	
	public function action_save_mimetypes()
	{
		$types = `cat /etc/mime.types`;
		
		// Remove comments
		$types = preg_replace('/\#.*'.PHP_EOL.'/', '', $types);
		
		// Remove multiple new lines
		$types = preg_replace('/'.PHP_EOL.'+/s', PHP_EOL, $types);
		
		// Remove starting and ending new lines
		$types = preg_replace('/^'.PHP_EOL.'|'.PHP_EOL.'$/s', '', $types);

		// Split the types string into array
		$types = explode(PHP_EOL, $types);
		
		foreach($types as $type)
		{			
			// Convert all consecutive whitespace chars to single tab space char
			$type = preg_replace('/\s+/', '\t', $type);
			
			// Split the mimetype (expected: mimetype	extension)
			$type = explode('\t', trim($type));
			
			// The mimetype needs to have at least one extension
			if (count($type) >= 2)
			{
				$mimetype = $type[0];
				
				unset($type[0]);
				
				foreach($type as $extension)
				{
					list($subtype, $maintype) = explode('/', $mimetype);

					$type_orm = ORM::factory('mimetype', array(
						'subtype' => $subtype,
						'type' => $maintype,
						'extension' => $extension
					));
					$type_orm->subtype = $subtype;
					$type_orm->type = $maintype;
					$type_orm->extension = $extension;
					$type_orm->save();
				}
			}
		}
	}
}
