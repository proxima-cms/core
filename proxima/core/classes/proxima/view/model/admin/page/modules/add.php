<?php defined('SYSPATH') or die('No direct script access.');

class Proxima_View_Model_Admin_Page_Modules_Add extends View_Model_Admin {

	protected $upload_types = array('tar', 'zip');

	public function __construct($file = NULL, array $data = NULL)
	{
		parent::__construct($file, $data);

		$this->breadcrumb(array('add', Request::current()->uri()));
	}

	public function var_allowed_upload_type()
	{
		return implode(', ', $this->upload_types);
	}

	public function var_allowed_github_urls()
	{
		return implode(', ', array('git://', 'http://'));
	}

	public function var_max_file_uploads()
	{
		return 1;
	}
}
