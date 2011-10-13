<?php 
/**
 *
 * The Tumblr Import module will import posts and tags from a tumblr XML feed.
 *
 * @author	Richard Willis
 * @package	PyroCMS
 * @subpackage	TumblrImport
 * @category	Modules
 * @license	Apache License v2.0
 */

class Controller_Admin_BlogImport extends Controller_Admin_Base {

	/**
	 * Validation callback method that checks the format of the feed URL
	 * @access public
	 * @param string url The URL to check
	 * @return bool
	 */
	public static function validation_check_url($url)
	{
		if (!preg_match('/^https?:\/\/.+/', $url))
		{
			return FALSE;
		}
		// Strip end slashes
		$url = preg_replace('/[\/]+$/', '', $url);

		return true;
	}

	/**
	 * Main request
	 * @access public
	 * @return void
	 */
  public function action_index()
  {
    $this->template->title = __('Blog import');
    $this->template->content = View::factory('admin/page/blogimport/index');

    //$data = Validation::factory($_POST);
      //->rule('blog_url', 'not_empty')
      //->rule('blog_url', array($this, 'validation_check_url'));

		if ($_POST)
		{
			$result = Importer::factory('Tumblr', $_POST)
				->import_posts();
			}

	//		if ($result === FALSE)
	//		{
	//			$this->session->set_flashdata('error', 'Error loading XML feed.');
	//			redirect('admin/tumblrimport');
	//		} 

	//		$flashmsg = sprintf('Saved %s of %s posts.', 
	//			$result['saved'],
	//			$result['total_posts']
	//		);

	//		$this->session->set_flashdata($result['saved'] ? 'success' : 'error', $flashmsg);
	//		redirect('admin/tumblrimport');
		//}
		//else
		//{
		//	$errors = $data->errors();
	//	}
	}
}
