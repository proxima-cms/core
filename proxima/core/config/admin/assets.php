<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'allowed_upload_type'	=> 'jpg,png,gif,pdf,txt,zip,tar',
	'upload_path'					=> 'media/assets',
	'max_file_uploads'		=> 5,
	'scripts'	=> array(
		Proxima::media('js/admin/assets/assets.js')
	),
	'styles'	=> array(
		Proxima::media('css/admin/assets/assets.css')
	),
);
