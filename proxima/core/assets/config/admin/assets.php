<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'allowed_upload_type'	=> 'jpg,png,gif,pdf,txt,zip,tar',
	'upload_path'					=> 'media/assets',
	'max_file_uploads'		=> 5,
	'scripts'	=> array(
		Core::path('assets/media/js/admin/assets.js')
	),
	'styles'	=> array(
		Core::path('assets/media/css/admin/assets.css')
	),
);
